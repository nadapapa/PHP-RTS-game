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
            $this->deleteFinishedTask($building->task);

            if ($building->workers > 0) {
                if ($building->type == 7) {
                    if ($city->hasEnoughResources(City::$worker_price[$city->nation])) {
                        $city->resources->subtract(City::$worker_price[$city->nation]);
                        $this->createTask($building, 1, City::$worker_time[$city->nation]);

                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id");
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
