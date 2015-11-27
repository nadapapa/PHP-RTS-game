<?php namespace App\Http\Controllers;


use App\Grid;
use App\Http\Requests;
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
            $city = City::find($id);
        } else {
            return redirect('/home')->withErrors('Nem a te városod');
        }

        $building_slot = $city->building_slot;

        $buildings = $building_slot->building;

        $building_slot = array_slice($building_slot->toArray(), 3, $building_slot['active_slots']);

        return view('city', ['city' => $city, 'building_slot' => $building_slot, 'buildings' => $buildings, 'help' => '/help/city']);
    }


    public function  postCity()
    {

    }


    public function getNewCity()
    {

//        $hex_id = $this->randomHex();

//        echo $hex_id;
//        $name = "róma2";
//        $this->createCity(Auth::user(), 0, $hex_id, $name);
        return "ok";

    }
}