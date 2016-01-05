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
        $crossing = null;

        // filter those steps which have already done
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
     * checks if the crossing of the two armies was at the same time
     * if the armies were 'crash' in each other.
     * if so then call the self::createBattle() method.
     *
     * @param array $crossing
     */
    public static function processPathCrossing(array $crossing)
    {
        // check if the two armies were on the same location at the same time
        if ($crossing[1]->started_at->between($crossing[0]->started_at, $crossing[0]->finished_at)) { // if the main path was on the hex first
            self::processBattle($crossing[1], $crossing[0]);
        } elseif ($crossing[0]->started_at->between($crossing[1]->started_at, $crossing[1]->finished_at)) { // if the secondary path was on the hex first
            self::processBattle($crossing[0], $crossing[1]);
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
    public static function processBattle(Path $attacking_path, Path $attacked_path)
    {
        $attacking_army = $attacking_path->army;
        $attacked_army = $attacked_path->army;

        $points = self::calculateArmiesPoints($attacking_army, $attacked_army);

        $attacking_attack = $points['attack_points'][0]; // attacking army's attack points
//        $attacked_attack = $points['attack_points'][1]; // attacked army's attack points
//        $attacking_defense = $points['defense_points'][0]; // attacking army's defense points
        $attacked_defense = $points['defense_points'][1]; // attacked army's defense points

//        $attacked_defense -= $attacking_attack;
//        $attacking_defense -= $attacked_attack;

        // TODO include hex modifier in the calculation
        // TODO armies of the same user should not engage in battle with each other
        // TODO the allies should not too
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
        // TODO az egész csatarendszert beépíteni a mozgás rendszerbe
        // TODO a csata eredményét megjeleníteni a felhasználónak

    }

    public static function calculateCasualties(Army $army, $points)
    {



    }

    // delete army and its path, task(s) and id from hex
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
}
