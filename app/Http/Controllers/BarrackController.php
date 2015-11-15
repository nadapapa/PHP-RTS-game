<?php namespace App\Http\Controllers;

use App\Army;
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

    public function postTrainUnit(Request $request, $city_id, $slot_num, $building_id)
    {
        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $type = $request->input('type');

        if ($building = $this->buildingCompleted($building_id)) {
            $this->checkTasks();
            if ($building->workers > 0) {
                if ($building->type == 5) {
                    if ($city->hasEnoughResources(Army::$unit_prices[$city->nation][$type])) {
                        if ($city->resources->population > 0) {
                            if ($city->hex->army_id == 0) {
                                $army = Army::create([
                                    'user_id' => $city->owner,
                                    'current_hex_id' => $city->hex->id
                                ]);
                                $city->hex->army_id = $army->id;
                                $city->hex->save();
                            }

                            $city->resources->population -= 1;
                            $city->resources->save();
                            $city->resources->subtract(Army::$unit_prices[$city->nation][$type]);
                            $this->createTask($building, $type + 10, Army::$unit_times[$city->nation][$type]);


                            return redirect("/city/$city_id");

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
//        $army->$unit_type += 1;
//        $army->save();

    }

}
