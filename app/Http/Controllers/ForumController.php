<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Building;
use App\City;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{

    use BuildingTraits;

    /**
     * @param $city_id
     * @param $slot_num
     */
    public function getMakeWorker($city_id, $slot_num, $building_id)
    {
        $city = $this->validateOwner($city_id);

        if ($building = $this->buildingCompleted($building_id)) {
            $this->checkTasks();

            if ($building->task->where('building_id', $building->id)->first()) {
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['already_training' => 'Az épület használatban van']);
            }

            if ($building->workers > 0) {
                if ($building->type == 7) {
                    if ($city->hasEnoughResources(City::$worker_price[$city->nation])) {
                        if ($city->resources->population > 0) {
                            $city->resources->population -= 1;
                            $city->resources->save();
                            $city->resources->subtract(City::$worker_price[$city->nation]);
                            $this->createTask($building, 1, City::$worker_time[$city->nation]);

                            return redirect("/city/$city_id/slot/$slot_num/building/$building_id");
                        }
                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_population' => 'Nincs elég népesség']);
                    }
                    return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_resources' => 'Nincs elég nyersanyag']);
                }
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_a_forum' => 'Az épület nem tud munkást képezni']);
            }
            return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_worker' => 'Az épületben nem dolgozik munkás']);
        }
        return redirect("/city/$city_id");
    }


    /**
     * @param $city_id
     * @param $slot_num
     */
    public function getMakeSettler($city_id, $slot_num, $building_id)
    {
        $city = $this->validateOwner($city_id);

        if ($building = $this->buildingCompleted($building_id)) {
            $this->checkTasks();

            if ($building->task->where('building_id', $building->id)->first()) {
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['already_training' => 'Az épület használatban van']);
            }

            if ($building->workers > 0) {
                if ($building->type == 7) {
                    if ($city->hasEnoughResources(City::$settler_price[$city->nation])) {
                        if ($city->resources->workers >= 5) {
                            if ($city->resources->population >= 10) {
                                $city->resources->workers -= 5;
                                $city->resources->population -= 10;
                                $city->resources->save();
                                $city->resources->subtract(City::$settler_price[$city->nation]);
                                $this->createTask($building, 2, City::$settler_time[$city->nation]);

                                return redirect("/city/$city_id/slot/$slot_num/building/$building_id");
                            }
                            return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_population' => 'Nincs elég népesség']);
                        }
                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_worker' => 'Nincs elég munkás']);
                    }
                    return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_resources' => 'Nincs elég nyersanyag']);
                }
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_a_forum' => 'Az épület nem tud munkást képezni']);
            }
            return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_worker' => 'Az épületben nem dolgozik munkás']);
        }
        return redirect("/city/$city_id");
    }
}
