<?php namespace App\Http\Controllers\Buildings;

use App\Army;
use App\Http\Controllers\TaskController;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Building;
use App\City;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarrackController extends Controller
{
    use BuildingTraits;


    /**
     * creates the unit training task based on the submitted POST request.
     *
     * @param Request $request
     * @param $city_id
     * @param $slot_num
     * @param $building_id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postTrainUnit(Request $request, $city_id, $slot_num, $building_id)
    {
        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $type = $request->input('type');

        if ($building = $this->buildingCompleted($building_id)) { // check if the building is completed
            TaskController::checkTasks(); // check if there any pending tasks and complete the finished ones
            if ($building->workers > 0) { // check if there's at least one worker in the building
                if ($building->type == 5) { // check if the type of the building is 'barrack'
                    $lack_resource = $city->hasEnoughResources(Army::$unit_prices[$city->nation][$type]);
                    if (empty($lack_resource)) { // check if the city has enough resources to train the unit
                        if ($city->human_resources->population > 0) { // check if the city has enough population (i.e. at least 1)
                            $city->human_resources->population -= 1;
                            $city->human_resources->save(); // if everything is set, remove one from the population of the city and save the new population

                            $city->resources->subtract(Army::$unit_prices[$city->nation][$type]); // remove the amount of resources needed by the training of the unit
                            TaskController::createTask($building, $type + 10, Army::$unit_times[$city->nation][$type]); // create the task


                            return redirect("/city/$city_id/slot/$slot_num/building/$building_id");
                        }
                        return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_population' => 'Nincs elég népesség']);
                    }
                    $messages = [];
                    $resources = [
                        'stone' => 'kő',
                        'lumber' => 'fa',
                        'food' => 'élelmiszer',
                        'iron' => 'vas'
                    ];
                    foreach ($lack_resource as $key => $value) {
                        $messages["not_enough_$key"] = "Még $value $resources[$key] hiányzik";
                    }

                    return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors($messages);
                }
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_a_forum' => 'Az épület nem tud munkást képezni']);
            }
            return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['not_enough_worker' => 'Az épületben nem dolgozik munkás']);
        }
        return redirect("/city/$city_id");
    }

}
