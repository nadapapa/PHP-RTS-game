<?php namespace App\Http\Controllers;

use App\Battle;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Army;
use App\Grid;
use App\Path;
use App\Task;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ArmyController extends Controller
{

    /**
     * creates the path and task based on the request sent from the map
     *
     * @param Request $request
     * @return $this
     */
    public function postMoveArmy(Request $request)
    {
        TaskController::checkTasks();

        $path = $request->input('path');
        $army_id = $request->input('army');

        $army = Army::where('id', $army_id)->first();

        if(!$army->general){
            return false;
        }

        if (Auth::user()->id != $army->user_id) {
            return redirect('/home')->withErrors('Nem a te sereged');
        }

        // calculate the speed of the army.
        // it is the speed of the slowest unit (i.e. the bigger number in speed table)
        $units = [
            1 => intval($army->unit1),
            2 => intval($army->unit2),
            3 => intval($army->unit3),
            4 => intval($army->unit4),
            5 => intval($army->unit5),
            6 => intval($army->unit6),
            7 => intval($army->unit7)
        ];
        $speed = [];
        foreach ($units as $key => $value) {
            if ($value > 0) {
                $speed[] = Army::$unit_speeds[$army->user->nation][$key];
            }
        }
        $speed = max($speed);

        $path_id = (DB::table('paths')->max('path_id')) + 1;

        $time = 0;
        $finished = Carbon::now();
        $l = sizeof($path);

        for ($i = 1; $i < $l; $i++) {
            $hex = Grid::
            where("x", $path[$i]['x'])
                ->where('y', $path[$i]['y'])
                ->select('id', 'type')
                ->first();
            $time += Grid::$price[intval($hex->type)] * $speed;

            $path_hex = Path::create([
                'path_id' => $path_id,
                'hex_id' => $hex->id,
                'started_at' => $finished
            ]);

            $finished = Carbon::now()->addSeconds($time);

            $path_hex->finished_at = $finished;

            $path_hex->save();
        }


        $task = TaskController::createTask($army, 20, $time);
        $task->path_id = $path_id;
        $task->save();

        $army->task_id = $task->id;
        $army->path_id = $path_id;
        $army->save();

        return $army->id;

    }


    /**
     * checks each step of the path if it was completed (based on its timestamp).
     * also calls the findCrossingPath method to (surprise!) find the paths crossing the current path
     *
     * @param Task $task
     */
    public static function pathProgress(Task $task)
    {
        if ($task->path->isEmpty()) {
            $task->army->update(['task_id' => 0, 'path_id' => 0]);
            $task->delete();
            return;
        }

        $path = $task->path;
        self::processFoodConsumption($path);

        $finished = null;

        $path->filter(function ($item) use (&$finished) {
            if ($item->finished_at <= Carbon::now()) { // if the step is finished
                self::findCrossingPath($item);
                $finished = $item;
                $item->delete();
            }
        });

        // now $finished is the last element of the path.
        // $finished has the hex where the army is
        if ($finished != null) {
            $army = $task->army;
            $army->currentHex->update(['army_id' => 0]);
            $army->update(['current_hex_id' => $finished->hex_id]);
            $finished->hex->update(['army_id' => $army->id]);
        }

        if ($path->isEmpty()) {
            $task->army->update(['task_id' => 0, 'path_id' => 0]);
            $task->delete();
        }
    }

    public static function processFoodConsumption($path)
    {
        $first = $path->first();
        $time = $first->started_at->diffInSeconds(Carbon::now());
        $army = $first->army;
        $army->food -= ($army->calculateFoodConsumption()/3600) * $time;
        $army->save();
    }


    /**
     * Finds the step in the path which crossed, and also finds the crossing path's step.
     * finds out if there is an obstacle in the way (standing army, city, etc)
     * so it checks if there were two armies in the same location,
     * but it does not check the time factor, that's the job of self::processPathCrossing()
     *
     * @param Collection $path
     * @return array|null   the array has 2 elements: the step of the crossing path
     *                      and the step of the crossed path
     */
    public static function findCrossingPath(Path $path)
    {
        $crossing = null;

        $query = Path::where('hex_id', '=', $path->hex_id)->where('path_id', '<>', $path->path_id)->first();

        if ($query !== null) { // if there is a crossing path
            self::processPathCrossing($query, $path);
        }

        $query = $path->hex->army_id;
        if ($query > 0) { // check if there is a standing army in the way
           self::processArmyCrossing($path->hex->army, $path);
        }

        if ($path->hex->city_id > 0) { // check if there is a city in the way
            if($path->hex->owner != $path->army->user_id){
                SiegeController::processSiege($path->army, $path->hex->city);
            }
        }
//        return $crossing;
    }

    /**
     * determines if the meeting armies are friends or foes.
     *
     * @param Army $army
     * @param Path $step
     */
    public static function processArmyCrossing(Army $army, Path $step)
    {
        if ($army->user_id === $step->army->user_id){ // if the two armies belong to the same user
            self::processFriendlyArmiesMeeting($step->army, $army);
        } else { // if the two armies are enemies
            self::processBattle($step->army, $army);
        }
    }


    /**
     * checks if the crossing of the two armies was at the same
     * time and determines which one was there first.
     * the first is the attacked army the second is the attacking.
     * also checks if the owner of the two armies was the same one.
     *
     * @param array $crossing
     */
    public static function processPathCrossing(Path $crossing0, Path $crossing1)
    {
        $attacked = null;
        $attacking = null;

        // check if the two armies were on the same location at the same time
        if ($crossing1->started_at->between($crossing0->started_at, $crossing0->finished_at)) { // if the main path was on the hex first
            $attacking = $crossing1;
            $attacked = $crossing0;
        } elseif ($crossing0->started_at->between($crossing1->started_at, $crossing1->finished_at)) { // if the secondary path was on the hex first
            $attacking = $crossing0;
            $attacked = $crossing1;
        }

        if($attacking !== null && $attacked !== null) {
            if ($attacking->user == $attacked->user) {
                // attacked is the first, attacking is the second army on that hex
                self::processFriendlyArmiesMeeting($attacking, $attacking->army);
            } else {
                self::processBattle($attacking->army, $attacked->army);
            }
        }
    }


    /**
     * calculates the time duration of the battle
     * currently the calculation is simple: 1 second / unit
     *
     * @param Army $attacking_army
     * @param Army $attacked_army
     * @return int
     */
    public static function calculateBattleTime(Army $attacking_army, Army $attacked_army)
    {
        /** @var int $time */
        $time = $attacking_army->getUnitsSum() + $attacked_army->getUnitsSum();
        return $time;
    }

    /**
     * @param Path $second
     * @param Army $attacking
     */
    public static function processFriendlyArmiesMeeting(Path $second, Army $attacking)
    {
        $path = $second->path;
        $previous = $second;

        if($second->id !== $path->min('id')){
            $previous_id = $second->id - 1;
            $previous = Path::where('id', '=', $previous_id)->first();
        }

        $previous->hex->army_id = $attacking->id;
        $previous->deletePath();

        $attacking->task->delete();
        $attacking->current_hex_id = $previous->hex->id;
        $attacking->task_id = 0;
        $attacking->path_id = 0;
        $attacking->currentHex->update(['army_id' => 0]);
        $attacking->save();
    }

}
