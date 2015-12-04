<?php namespace App\Http\Controllers;

use App\Army;
use App\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{


    /**
     * @param $owner
     * @param $type
     * @param $time
     */
    public static function createTask($owner, $type, $time)
    {
        $task = Task::create([
            'type' => $type,
            'finished_at' => Carbon::now()->addSeconds($time)
        ]);

        switch (get_class($owner)) {
            case 'App\User':
                $task->user_id = $owner->id;
                break;
            case 'App\City':
                $task->city_id = $owner->id;
                break;
            case 'App\Building':
                $task->building_id = $owner->id;
                break;
            case 'App\Army':
                $task->army_id = $owner->id;
                break;
        }

        $task->save();

        return $task;

    }


    /**
     *
     */
//    public function checkTasks()
//    {
//        $user = Auth::user();
//
//        if (!empty($user->task)) {
//            $user->task->each(function ($user_task) {
//                if ($user_task->finished_at->lte(Carbon::now())) {
//                    $this->finishTask($user_task);
//                    $user_task->delete();
//                }
//            });
//        }
//
//        if ($user->cities) {
//            foreach ($user->cities as $city) {
//                if (!empty($city->task)) {
//                    $city->task->each(function ($city_task) {
//                        if ($city_task->finished_at->lte(Carbon::now())) {
//                            $this->finishTask($city_task);
//                            $city_task->delete();
//                        }
//                    });
//                }
//
//                foreach ($city->building_slot->building as $building) {
//
//                    if ($building->task) {
//                        $building->task->each(function ($building_task) {
//                            if ($building_task->finished_at->lte(Carbon::now())) {
//                                $this->finishTask($building_task);
//                                $building_task->delete();
//                            }
//                        });
//                    }
//                }
//            }
//        }
//
//        if ($user->armies) {
//            foreach ($user->armies as $army) {
//                if (!empty($army->task)) {
//                    $army->task->each(function ($army_task) {
//                        if ($army_task->finished_at->lte(Carbon::now())) {
//                            $this->finishTask($army_task);
//                            $army_task->delete();
//                        }
//                    });
//                }
//            }
//        }
//
//
//
//    }


    public static function checkTasks()
    {
        $finished_tasks = Task::where('finished_at', '<=', Carbon::now())->orWhere('type', 20)->get();
        $finished_tasks->each(function ($task) {
            self::finishTask($task);
        });
    }

    /**
     * @param Task $task
     */
    public static function finishTask(Task $task)
    {
        switch ($task->type) {
            case 1: // create worker
                $task->building->city->resources->workers += 1;
                $task->building->city->resources->save();
                $task->delete();

                break;
            case 2: // create settler
                $task->building->city->resources->settlers += 1;
                $task->building->city->resources->save();
                $task->delete();

                break;
            case 11: // create unit
            case 12:
            case 13:
            case 14:
            case 15:
            case 16:
            case 17:
            if ($task->building->city->hex->army_id == 0) {
                $army = Army::create([
                    'user_id' => $task->building->city->owner,
                    'current_hex_id' => $task->building->city->hex->id
                ]);
                $task->building->city->hex->army_id = $army->id;
                $task->building->city->hex->save();
            }

            $unit_type = 'unit' . ($task->type - 10);

                $task->building->city->hex->army->$unit_type += 1;
                $task->building->city->hex->army->save();
                $task->delete();
                break;

            case 20: // move army
                self::pathProgress($task);
                break;

        }
    }


    /**
     * Undo task. For example when deleting a building which has an unfinished task
     * this method deletes the task and gives back the resources
     * @param Task $task
     */
    public static function undoTask(Task $task)
    {
        switch ($task->type) {
            case 1: // create worker
                $task->building->city->resources->add(City::$worker_price[$task->building->city->nation]);
                $task->building->city->resources->population += 1;
                $task->building->city->resources->save();
                break;
            case 2: // create settler
                $task->building->city->resources->add(City::$settler_price[$task->building->city->nation]);
                $task->building->city->resources->workers += 5;
                $task->building->city->resources->save();
                break;
            case 11: // create unit
            case 12:
            case 13:
            case 14:
            case 15:
            case 16:
            case 17:
                $task->building->city->resources->add(City::$worker_price[$task->building->city->nation]);
                $task->building->city->resources->population += 1;
                $task->building->city->resources->save();
                break;
        }
    }


    public static function pathProgress(Task $task)
    {
        $finished = null;
        $task->path->filter(function ($item) use (&$finished) {
            if ($item->finished_at <= Carbon::now()) {
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
            $task->army->update(['task_id' => 0]);
            $task->delete();
            return;
        }

    }

}
