<?php namespace App\Http\Controllers;

use App\Building;
use App\BuildingSlot;
use App\City;
use App\Task;
use App\User;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{

	use DispatchesCommands, ValidatesRequests;

	/**
	 * Finds out if the logged in user is the owner of the city.
	 *
	 * @param $city_id
	 * @return $this|\Illuminate\Support\Collection|null|static
	 */
	public function validateOwner($city_id)
	{
		$city = City::find($city_id);
		$userid = Auth::user()->id;

		try {
			if ($city->owner != $userid) {
				return redirect('/home')->withErrors('Ez nem a te városod');
			}
		} catch (ErrorException $e) {
			return redirect('/home')->withErrors(['Nincs ilyen város']);
		}

		return $city;
	}


    /**
     * @param City $city
     * @param $thing
     * @param array $price
     * @param $time
     * @return $this|bool
     */
    public function levelUp($city, $thing, array $price, $time)
    {
        if ($city->hasEnoughResources($price)) {
            $thing->level += 1;
            $thing->finished_at = Carbon::now()->addSeconds($time);
            $city->resources->subtract($price);
            $thing->save();
            return true;
        }
        return redirect()->back()->withErrors(['not_enough_resources' => 'Nincs elég nyersanyag']);
    }


    /**
     * @param $city
     * @param $thing
     * @param $price
     * @param $time
     * @param $health
     * @return $this|bool
     */
    public function heal($city, $thing, $price, $time, $health)
    {
        if ($thing->health + $health > 100) {
            return redirect("city/$city->id")->withErrors(['too_much_health' => '100%-nál nem lehet nagyobb']);
        }
        $thing->health += $health;
        $thing->finished_at = Carbon::now()->addSeconds($time);
        $city->resources->subtract($price);
        $thing->save();
        return true;
    }


    /**
     * @param $owner
     * @param $type
     * @param $time
     */
    public function createTask($owner, $type, $time)
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
        }

        $task->save();

        return $task;

    }


    /**
     * @param Task $task
     * @return bool
     * @throws \Exception
     */
    public function deleteFinishedTask(Task $task = null)
    {
        $now = new Carbon;
        if ($task != null) {
            if ($task->finished_at->lte($now)) {
                $task->delete();
                return true;
            }
        }
        return false;
    }


    public function checkTasks()
    {
        $user = Auth::user();
        if ($user->task) {
            foreach ($user->task->get() as $task) {
                $this->finishTask($task);
                $this->deleteFinishedTask($task);
            }
        }

        if ($user->cities) {
            foreach ($user->cities as $city) {
                if ($city->task) {
                    foreach ($city->task->get() as $city_task) {
                        $this->finishTask($task);
                        $this->deleteFinishedTask($city_task);
                    }
                }

                foreach ($city->building_slot->building as $building) {
                    if ($building->task) {
                        foreach ($building->task->get() as $building_task) {
                            $this->finishTask($building_task);
                            $this->deleteFinishedTask($building_task);
                        }
                    }
                }
            }
        }
    }


    /**
     * @param Task $task
     */
    public function finishTask(Task $task)
    {
        switch ($task->type) {
            case 1:
//                var_dump($task->building->city->resources->population);
                $task->building->city->resources->population -= 1;
                $task->building->city->resources->workers += 1;
                $task->building->city->resources->save();
        }
    }
}
