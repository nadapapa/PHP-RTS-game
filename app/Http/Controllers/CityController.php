<?php namespace App\Http\Controllers;


use App\Grid;
use App\Http\Requests;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Building;
use App\BuildingSlot;
use App\City;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CityController extends Controller
{
    /**
     * @param $id
     * @return $this|\Illuminate\View\View
     */
    public function getCity($id)
    {

        TaskController::checkTasks();

        if ($this->validateOwner($id)) {
            $city = City::where('id', $id)->first();

        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }


        $production = ResourceController::processProduction($city);

        $building_slot = $city->building_slot;

        $buildings = $building_slot->building;

        $wall = $building_slot->wall;
        $wall = Building::find($wall);

        $building_slot = array_slice($building_slot->toArray(), 3, 25);

        return view('city', [
            'city' => $city,
            'building_slot' => $building_slot,
            'buildings' => $buildings,
            'help' => '/help/city',
            'production' => $production,
            'wall' => $wall,
        ]);
    }

    public function getNewCity()
    {

//        $hex_id = $this->randomHex();

//        echo $hex_id;
//        $name = "róma2";
//        $this->createCity(Auth::user(), 0, $hex_id, $name);
        return "ok";

    }

    public function getWall($id)
    {
        TaskController::checkTasks();

        if ($this->validateOwner($id)) {
            $city = City::where('id', $id)->first();

        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $wall = $city->building_slot->wall;

        $wall = Building::find($wall);

        $production = ResourceController::processProduction($city);

        return view('wall', ['city' => $city, 'wall' => $wall, 'production' => $production]);
    }

    public function healWall(Request $request, $city_id)
    {
        if ($this->validateOwner($city_id)) {
            $city = City::find($city_id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $wall = $city->building_slot->wall;

        $wall = Building::find($wall);

        $this->validate($request, [
            'health' => 'required|integer|max:100',
        ]);
        $health = $request->input('health');

        $price = [
            'iron' => $health,
            'food' => $health,
            'stone' => $health,
            'lumber' => $health,
        ];

        $time = $health;

        $this->heal($city, $wall, $price, $time, $health);

        return redirect("/city/$city_id/wall");

    }
}