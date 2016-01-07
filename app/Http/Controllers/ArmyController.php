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

        $army_hex = Grid::
        where("x", $path[0]['x'])
            ->where('y', $path[0]['y'])
            ->select('army_id')
            ->first();

        $army = Army::where('id', $army_hex->army_id)->first();

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
                ->select('id', 'layer1')
                ->first();
            $time += Grid::$price[intval($hex->layer1)] * $speed;

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


    public static function pathProgress(Task $task)
    {
        if ($task->path->isEmpty()) {
            $task->army->update(['task_id' => 0, 'path_id' => 0]);
            $task->delete();
            return;
        }

        $crossing = self::findCrossingPath($task->path);
        if($crossing !== null){
            self::processPathCrossing($crossing);
        }

        $finished = null;

        $task->path->filter(function ($item) use (&$finished) {
            if ($item->finished_at <= Carbon::now()) { // if the path is finished
                $finished = $item;
                $item->delete();
            }
        });

        if ($finished != null) {
            $army = $task->army;
            $army->currentHex->update(['army_id' => 0]);
            $army->update(['current_hex_id' => $finished->hex_id]);
            $finished->hex->update(['army_id' => $army->id]);
        }

        if ($task->path->isEmpty()) {
            $task->army->update(['task_id' => 0, 'path_id' => 0]);
            $task->delete();
        }
    }


    /**
     * Finds the step in the path which crossed, and also finds the crossing path's step.
     * so it checks if there were two armies in the same location,
     * but it does not check the time factor, that's the job of self::processPathCrossing()
     *
     * @param Collection $path
     * @return array|null   the array has 2 elements: the step of the crossing path
     *                      and the step of the crossed path
     */
    public static function findCrossingPath(Collection $path)
    {
        // TODO find the stationary obstacles too (armies, cities, etc.)
        $crossing = null;

        // filter those steps which have already done
        // only the past matters here
        $path = $path->filter(function ($item) {
            return $item->finished_at <= Carbon::now();
        });

        foreach ($path as $step) {
            $query = Path::where('hex_id', '=', $step->hex_id)->where('path_id', '<>', $step['path_id'])->first();
            if ($query !== null) {
                $crossing = [$query, $step];
                break;
            }

        }

        return $crossing;
    }


    /**
     * checks if the crossing of the two armies was at the same time and determines which one was there first.
     * the first is the attacked army the second is the attacking.
     * also checks if the owner of the two armies was the same one.
     *
     * @param array $crossing
     */
    public static function processPathCrossing(array $crossing)
    {
        $attacked = null;
        $attacking = null;

        // check if the two armies were on the same location at the same time
        if ($crossing[1]->started_at->between($crossing[0]->started_at, $crossing[0]->finished_at)) { // if the main path was on the hex first
            $attacking = $crossing[1];
            $attacked = $crossing[0];
        } elseif ($crossing[0]->started_at->between($crossing[1]->started_at, $crossing[1]->finished_at)) { // if the secondary path was on the hex first
            $attacking = $crossing[0];
            $attacked = $crossing[1];
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
        $time = $attacking_army->getUnitsSum() + $attacked_army->getUnitsSum();

        return $time;
    }


    /**
     * @param Army $attacking_army
     * @param Army $attacked_army
     * @return array
     */
    public static function calculateArmiesPoints(Army $attacking_army, Army $attacked_army)
    {

        // TODO include modifiers (armour and weapon upgrades) in the calculation

        $attack_points = [0, 0];
        $defense_points = [0, 0];

        $attacking_units = $attacking_army->getUnits();

        $attacked_units = $attacked_army->getUnits();

        foreach ($attacking_units as $key => $unit) {
            if ($unit > 0) {
                $attack_points[0] += (Army::$unit_attack[$attacking_army->user->nation][$key] * $unit);
                $defense_points[0] += (Army::$unit_defense[$attacking_army->user->nation][$key] * $unit);
            }
        }

        foreach ($attacked_units as $key => $unit) {
            if ($unit > 0) {
                $attack_points[1] += (Army::$unit_attack[$attacked_army->user->nation][$key] * $unit);
                $defense_points[1] += (Army::$unit_defense[$attacked_army->user->nation][$key] * $unit);
            }
        }

        return ['attack_points' => $attack_points, 'defense_points' => $defense_points];
    }


    /**
     * @param Path $attacking_path
     * @param Path $attacked_path
     */
    public static function processBattle(Army $attacking_army, Army $attacked_army)
    {
        $points = self::calculateArmiesPoints($attacking_army, $attacked_army);

        $attacking_attack = $points['attack_points'][0]; // attacking army's attack points
//        $attacked_attack = $points['attack_points'][1]; // attacked army's attack points
//        $attacking_defense = $points['defense_points'][0]; // attacking army's defense points
        $attacked_defense = $points['defense_points'][1]; // attacked army's defense points

//        $attacked_defense -= $attacking_attack;
//        $attacking_defense -= $attacked_attack;

        // TODO include hex modifier in the calculation
        $point = $attacking_attack - $attacked_defense;

        if ($point == 0){ // it's a tie
            $point += rand(-1, 1); // randomly add or remove 1 so the $point will be 1 or -1
        } elseif ($point > 0){ // the attacking army wins
            $winner = $attacking_army;
            $loser = $attacked_army;
        } elseif ($point < 0) { // the attacked army wins
            $winner = $attacked_army;
            $loser = $attacking_army;
        }

        self::calculateCasualties($winner, $points);
        self::destroyArmy($loser);


//        $battle_time = self::calculateBattleTime($attacking_army, $attacked_army);

        // TODO a pontok alapján kiszámolni a veszteségeket és ennek megfelelően módosítani a seregeket
        // jelenleg a vesztes sereg teljesen megsemmisül, a győztesnek nincs vesztesége és folytatja az útját
        // TODO a csata eredményét megjeleníteni a felhasználónak

    }

    public static function calculateCasualties(Army $army, $points)
    {



    }

    // delete army and its path, task(s) and deletes its id from hex
    public static function destroyArmy(Army $army)
    {
        $army->task->delete();
        $army->path->each(function($path){
            $path->delete();
        });
        $army->currentHex->army_id = 0;
        $army->currentHex->save();
        $army->delete();
    }

    public static function processFriendlyArmiesMeeting(Path $second, Army $attacking)
    {
        $path = $second->path;

        $previous_id = $second->id;
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
        $attacking->currentHex->army_id = 0;

        $attacking->save();

    }
}
