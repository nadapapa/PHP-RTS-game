<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Building;
use App\BuildingSlot;
use App\City;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BuildingController extends Controller
{

    /**
     * @param $city_id
     * @param $slot_id
     * @return \Illuminate\View\View
     */
    public function getBuild($city_id, $slot_num)
    {
        $city = $this->validateOwner($city_id);

        $building_slot = $city->building_slot;
        $slot_arr = array_slice($building_slot->toArray(), 3, $building_slot['active_slots']);

        if ($slot_arr["slot$slot_num"] > 0) {
            return redirect("/city/$city_id/building/$slot_num");
        }
        return view('build', [
            'city' => $city,
            'slot_num' => $slot_num,
            'building_slot' => $building_slot,
        ]);
    }


    /**
     * @param Request $request
     */
    public function postBuild(Request $request, $city_id, $slot_num)
    {
        $city = $this->validateOwner($city_id);

        $type = $request->input('type');
        $slot = $city->building_slot;

        $this->createBuilding($type, $city, $slot_num, $slot);

        return redirect("city/$city_id");
    }


    /**
     * @param $city_id
     * @param $slot_num
     * @return $this|\Illuminate\View\View
     */
    public function getBuilding($city_id, $slot_num)
    {
        $city = $this->validateOwner($city_id);

        if ($building = $this->buildingCompleted($city, $slot_num)) {
            return view('building', ['city' => $city, 'building' => $building]);
        }


        return redirect("/city/$city->id")->withErrors(['no_building' => "Ezen az építési területen nem található épület"]);
    }


    /**
     * @param Request $request
     * @param $city_id
     * @param $slot_num
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postBuilding(Request $request, $city_id, $slot_num)
    {
        $city = $this->validateOwner($city_id);

        if ($request->has('workers')) {
            if ($building = $this->buildingCompleted($city, $slot_num)) {
                return $this->setWorkers($city, $building, $request);
            }

        }
        if ($request->has('health')) {
            $this->validate($request, [
                'health' => 'required|integer|max:100',
            ]);
            $health = $request->input('health');
            if ($building = $this->buildingCompleted($city, $slot_num)) {
                if ($building->workers > 0) {
                    $price = [
                        'iron' => $health,
                        'food' => $health,
                        'stone' => $health,
                        'lumber' => $health,
                    ];

                    $time = $health;

                    $this->heal($city, $building, $price, $time, $health);

                    return redirect("/city/$city->id");
                }
            }
        }

        return redirect("/city/$city->id")->withErrors(['no_building' => "Ezen az építési területen nem található épület"]);
    }


    /**
     * @param $city_id
     * @param $slot_num
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLevelUpBuilding($city_id, $slot_num)
    {
        $city = $this->validateOwner($city_id);

        if ($building = $this->buildingCompleted($city, $slot_num)) {
            if (($building->level + 1) > ($city->level * 5)) {
                return redirect("/city/$city_id/building/$slot_num")->withErrors(['low_city_level' => 'A város nem elég fejlett egy ilyen szintű épülethez']);
            }

            $price = Building::$building_prices[$city->nation][$building->type];
            foreach ($price as $key => &$value) {
                $value *= ($building->level + 1);
            }

            $time = (Building::$building_times[$city->nation][$building->type] * ($building->level + 1)) / $building->workers;
            $this->levelUp($city, $building, $price, $time);

            return redirect("/city/$city_id");
        }
        return redirect("/city/$city_id");
    }

    /**
     * @param $city_id
     * @param $slot_num
     */
    public function getDeleteBuilding($city_id, $slot_num)
    {
        $city = $this->validateOwner($city_id);

        if ($building = $this->buildingCompleted($city, $slot_num)) {
            $city->resources->add(['workers' => $building->workers]);
            $slot = "slot$slot_num";
            $city->building_slot->$slot = 0;

            $city->building_slot->save();
            $building->delete();
            return redirect("/city/$city_id");
        }
        return redirect("/city/$city_id")->withErrors(['not_yet' => 'Az épület még nincs kész']);
    }

    /**
     * @param $city_id
     * @param $slot_num
     */
    public function getMakeWorker($city_id, $slot_num)
    {
        $city = $this->validateOwner($city_id);

        if ($building = $this->buildingCompleted($city, $slot_num)) {
            if ($building->workers > 0 &&
                $building->type == 7 &&
                $city->hasEnoughResources(City::$worker_price[$city->nation])
            ) {
                $city->resources->population -= 1;
                $city->resources->workers += 1;

                $city->resources->save();

                return redirect("/city/$city_id/building/$slot_num");
            }
            return redirect("/city/$city_id/building/$slot_num")->withErrors(['not_enough_worker' => 'Az épületben nem dolgozik munkás']);
        }
        return redirect("/city/$city_id");
    }


    /**
     * @param City $city
     * @param $slot_num
     * @return $this|bool
     */
    public function buildingCompleted(City $city, $slot_num)
    {
        $building_slot = $city->building_slot;
        $slot_arr = array_slice($building_slot->toArray(), 3, $building_slot['active_slots']);

        if ($slot_arr["slot$slot_num"] > 0) {
            $building = $building_slot->building->find($slot_arr["slot$slot_num"]);

            if ($building->finished_at->gte(Carbon::now())) {
                $name = Building::$building_names[$city->nation][$building->type];
                return redirect("/city/$city->id")->withErrors(['not_yet' => "A $name még nincs kész"]);
            }
            return $building;
        }
        return false;
    }


    /**
     * @param City $city
     * @param Building $building
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function setWorkers(City $city, Building $building, Request $request)
    {
        $workers = $request->input('workers');
        // validate the request's number
        if ($workers > $building->level * 10 || $workers < 0) {
            return redirect($request->url())->withErrors(["no_more_worker" => "Az épületben nem dolgozhat ennyi munkás"]);
        }
        // check if the user want to add or remove workers.
        $diff = $workers - $building->workers;
        if ($city->hasEnoughResources(['workers' => $diff])) {

            $city->resources->subtract(['workers' => $diff]);

            $building->workers = $workers;
            $building->save();

            return redirect($request->url());
        }
        return redirect($request->url())->withErrors(['not_enough_worker' => "Nincs elég munkás"]);
    }


    /**
     * Creates a new building
     *
     * @param $type @int The type of the building.
     * @param $city @int The id of the city in which the building is built.
     * @param $slot @int The id of the slot on which the building is built.
     */
    private function createBuilding($type, City $city, $slot_num, BuildingSlot $slot)
    {
        $price = Building::$building_prices[$city->nation][$type];
        if ($city->hasEnoughResources($price)) {
            $finished = Carbon::now()->addSeconds(Building::$building_times[$city->nation][$type]);

            $building = Building::create([
                'type' => $type,
                'city' => $city->id,
                'slot' => $slot->id,
                'nation' => $city->nation,
                'finished_at' => $finished
            ]);

            $slot->update(["slot$slot_num" => $building->id]);

            $city->resources->subtract($price);
        } else {
            return redirect("city/$city->id")->withErrors(['not_enough_resources' => 'Nincs elég nyersanyagod az építkezéshez']);
        }

    }

}
