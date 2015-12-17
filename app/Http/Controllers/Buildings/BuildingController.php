<?php namespace App\Http\Controllers\Buildings;

use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TaskController;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Building;
use App\BuildingSlot;
use App\City;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BuildingController extends Controller
{
    use BuildingTraits;


    /**
     * shows the page for build a new building
     *
     * @param $city_id
     * @param $slot_id
     * @return \Illuminate\View\View
     */
    public function getBuild($city_id, $slot_num)
    {
        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $building_slot = $city->building_slot;
        $slot_arr = array_slice($building_slot->toArray(), 3, $building_slot['active_slots']);

        if ($slot_arr["slot$slot_num"] > 0) {
            return redirect("/city/$city_id")->withErrors(['occupied' => 'Ez az építési hely már foglalt']);
        }

        $production = ResourceController::processProduction($city);

        return view('build', [
            'city' => $city,
            'slot_num' => $slot_num,
            'building_slot' => $building_slot,
            'production' => $production
        ]);
    }


    /**
     * makes a new building based on the POST request
     *
     * @param Request $request
     * @param $city_id
     * @param $slot_num
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postBuild(Request $request, $city_id, $slot_num)
    {
        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $type = $request->input('type');

        $this->createBuilding($type, $city, $slot_num);

        return redirect("city/$city_id");
    }


    /**
     * shows the selected building
     *
     * @param $city_id
     * @param $slot_num
     * @param $building_id
     * @return $this|\Illuminate\View\View
     */
    public function getBuilding($city_id, $slot_num, $building_id)
    {
        TaskController::checkTasks();

        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $production = ResourceController::processProduction($city);

        if ($building = $this->buildingCompleted($building_id)) {
            return view('building', [
                'city' => $city,
                'building' => $building,
                'production' => $production]);
        }


        return redirect("/city/$city->id")->withErrors(['no_building' => "Ezen az építési területen nem található épület"]);
    }


    /**
     * sets the number of workers in the selected building
     *
     * @param Request $request
     * @param $city_id
     * @param $slot_num
     * @param $building_id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSetWorkers(Request $request, $city_id, $slot_num, $building_id)
    {
        $this->validate($request, [
            'workers' => 'required|integer',
        ]);

        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        if ($building = $this->buildingCompleted($building_id)) {

            TaskController::checkTasks();

            return $this->setWorkers($city, $building, $request);
        }
        return redirect("/city/$city_id");
    }


    /**
     * heals the selected building as much as the user require.
     *
     * @param Request $request
     * @param $city_id
     * @param $slot_num
     * @param $building_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postHeal(Request $request, $city_id, $slot_num, $building_id)
    {
        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $this->validate($request, [
            'health' => 'required|integer|max:100',
        ]);
        $health = $request->input('health');
        if ($building = $this->buildingCompleted($building_id)) {
            if ($building->workers > 0) {
                $price = [
                    'iron' => $health,
                    'food' => $health,
                    'stone' => $health,
                    'lumber' => $health,
                ];

                $time = $health;

                $this->heal($city, $building, $price, $time, $health);

                return redirect("/city/$city_id");
            }
        }
    }



    /**
     * Creates a new building
     *
     * @param $type @int                The type of the building.
     * @param City $city @int           The id of the city in which the building is built.
     * @param $slot_num @int            The number of the slot on which the building going to be built.
     * @param BuildingSlot $slot @int   The id of the slot on which the building is built.
     * @return $this
     */
    private function createBuilding($type, City $city, $slot_num)
    {
        $price = Building::$building_prices[$city->nation][$type];
        if ($city->hasEnoughResources($price)) {
            $finished = Carbon::now()->addSeconds(Building::$building_times[$city->nation][$type]);

            $slot = $city->building_slot;

            $building = Building::create([
                'type' => $type,
                'city_id' => $city->id,
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


    /**
     * deletes the selected building
     *
     * @param $city_id
     * @param $slot_num
     */
    public function getDeleteBuilding($city_id, $slot_num, $building_id)
    {
        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        if ($building = $this->buildingCompleted($building_id)) {
            $city->human_resources->add(['workers' => $building->workers]);
            $slot = "slot$slot_num";
            $city->building_slot->$slot = 0;
            $city->building_slot->save();

            $building->task->each(function ($task) {
                TaskController::undoTask($task);
                $task->delete();
            });

            $building->delete();

            return redirect("/city/$city_id");
        }
        return redirect("/city/$city_id")->withErrors(['not_yet' => 'Az épület még nincs kész']);
    }


}
