<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Army;
use App\Grid;
use App\Path;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ArmyController extends Controller
{

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
        $l = sizeof($path);
        for ($i = 1; $i < $l; $i++) {
            $hex = Grid::
            where("x", $path[$i]['x'])
                ->where('y', $path[$i]['y'])
                ->select('id', 'layer1')
                ->first();
            $time += Grid::$price[intval($hex->layer1)] * $speed;

            $finished = Carbon::now()->addSeconds($time);

            $path_hex = Path::create([
                'path_id' => $path_id,
                'hex_id' => $hex->id,
                'finished_at' => $finished
            ]);

            $path_hex->save();
        }


        $task = TaskController::createTask($army, 20, $time);
        $task->path_id = $path_id;
        $task->save();

        $army->task_id = $task->id;
        $army->save();

        return $army->id;

    }


    public function moveArmyOnPath()
    {

    }



}
