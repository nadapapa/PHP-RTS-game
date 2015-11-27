<?php namespace App\Http\Controllers\Buildings;

use App\Building;
use App\City;
use App\Http\Requests;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait BuildingTraits
{

    /**
     * @param $city_id
     * @param $slot_num
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLevelUpBuilding($city_id, $slot_num, $building_id)
    {
        $city = $this->validateOwner($city_id);

        if ($building = $this->buildingCompleted($building_id)) {
            if (($building->level + 1) > ($city->level * 5)) {
                return redirect("/city/$city_id/slot/$slot_num/building/$building_id")->withErrors(['low_city_level' => 'A város nem elég fejlett egy ilyen szintű épülethez']);
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
     * @param City $city
     * @param $slot_num
     * @return $this|bool
     */
    public function buildingCompleted($building_id)
    {
        $building = Building::where('id', $building_id)->first();

        if ($building->finished_at->gte(Carbon::now())) {
            return false;
        }
        return $building;
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

            return redirect()->back();
        }
        return redirect()->back()->withErrors(['not_enough_worker' => "Nincs elég munkás"]);
    }

}
