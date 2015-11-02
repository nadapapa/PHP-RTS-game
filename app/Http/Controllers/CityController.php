<?php namespace App\Http\Controllers;


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
        $this->checkTasks();

        $city = $this->validateOwner($id);

        $building_slot = $city->building_slot;

        $buildings = $building_slot->building;

        $building_slot = array_slice($building_slot->toArray(), 3, $building_slot['active_slots']);
//            print_r(var_dump($buildings->find(6)));
        return view('city', ['city' => $city, 'building_slot' => $building_slot, 'buildings' => $buildings]);
    }


    public function  postCity()
    {

    }


}