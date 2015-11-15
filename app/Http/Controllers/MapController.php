<?php

namespace App\Http\Controllers;

use App\Army;
use App\City;
use App\Grid;
use App\User;
use Crypt;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{

    /**
     * @param $x
     * @param $y
     * @return \Illuminate\View\View
     */
    public function getMap()
    {
        return view('map')->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
    }

    public function getCities()
    {
        return Grid::where("city", '>', 0)->get()->toJson();
    }

    public function getArmies()
    {
        return Grid::where("army_id", '>', 0)->get()->toJson();
    }

    public function getHexData(Request $request)
    {
        $hex = Grid::
        where("x", $request->input('x'))
            ->where('y', $request->input('y'))
            ->select('layer1', 'owner', 'city', 'army_id')
            ->first()->toArray();

        foreach ($hex as $key => &$value) {
            $value = intval($value);
        }

        if ($hex['owner'] > 0) {
            $hex['owner'] = User::find($hex['owner'])->name;
        }

        if ($hex['city'] > 0) {
            $city = City::find($hex['city']);
            $hex['nation'] = intval($city->nation);
            $hex['city'] = $city->name;
        }

//        if($hex['army_id'] > 0){
//            $army = Army::find($hex['army_id']);
//            $user = User::find($army->user_id);
//            $hex['army_owner'] = $user->name;
//            $hex['nation'] = intval($user->nation);
//            if ($user == Auth::user()){
//                $hex['unit1'] = $army->unit1;
//                $hex['unit2'] = $army->unit2;
//                $hex['unit3'] = $army->unit3;
//                $hex['unit4'] = $army->unit4;
//                $hex['unit5'] = $army->unit5;
//                $hex['unit6'] = $army->unit6;
//                $hex['unit7'] = $army->unit7;
//            }
//        }

        return $hex;
    }

    public function getCityData(Request $request)
    {
        return City::where('id', $request->input('city'))->first()->toJson();
    }

    public function getArmyData(Request $request)
    {
        $army = Army::where('id', $request->input('army_id'))->first()->toArray();

        $hex = Grid::find($army['current_hex_id']);

        // if there's a city on the current hex
        if ($hex->city > 0) {
            $city = City::find($hex->city);
            $army['city_nation'] = intval($city->nation);
            $army['city_name'] = $city->name;
        }

        $army['hex_layer1'] = $hex->layer1;
        $army['hex_owner'] = User::find($hex->owner)->name;

        if (Auth::user()->id === $army['user_id']) {
            return $army;
        } else {
            $units = [
                'unit1' => 0,
                'unit2' => 0,
                'unit3' => 0,
                'unit4' => 0,
                'unit5' => 0,
                'unit6' => 0,
                'unit7' => 0];

            $army = array_diff_key($army, $units);
            $user = User::find($army['user_id']);
            $army['army_owner'] = $user->name;
            $army['nation'] = intval($user->nation);

            return $army;
        }
    }




    /**
     * @param Request $request
     * @return string
     */
    public function ajaxMap(Request $request)
    {
        $view_width = 9;
        $view_height = 5;

        $x = $request->input('x');
        $y = $request->input('y');

        $grid = $this->showMap($x, $y, $view_width, $view_height);
        return json_encode($grid);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMap($x = 4, $y = 2, $view_width = 9, $view_height = 5)
    {
        $map_width = 20;
        $map_height = 10;

        if ($x < ($view_width - 1) / 2) {
            $x = ($view_width - 1) / 2;
        }
        if ($y < ($view_height - 1) / 2) {
            $y = ($view_height - 1) / 2;
        }

        if ($x > $map_width - (($view_width - 1) / 2) - 1) {
            $x = $map_width - (($view_width - 1) / 2) - 1;
        }
        if ($y > $map_height - (($view_height - 1) / 2) - 1) {
            $y = $map_height - (($view_height - 1) / 2) - 1;
        }

        $grid = Grid::whereBetween('x', [$x - (($view_width - 1) / 2), $x + (($view_width - 1) / 2)])
            ->whereBetween('y', [$y - (($view_height - 1) / 2), $y + (($view_height - 1) / 2)])->get()->toArray();

        $ny = 0;
        $nx = -1;

        foreach ($grid as &$row) {

            $nx++;

            if ($row['owner'] > 0) {
                $user = User::find($row['owner']);
                $username = $user->name;
                $row['owner_name'] = $username;
                switch ($user->nation) {
                    case 0:
                        $row['nation'] = 'nincs';
                        break;
                    case 1:
                        $row['nation'] = 'római';
                        break;
                    case 2:
                        $row['nation'] = 'görög';
                        break;
                    case 3:
                        $row['nation'] = 'germán';
                        break;
                    case 4:
                        $row['nation'] = 'szarmata';
                        break;
                }
            }


            if ($row['city'] > 0) {
                $user = User::find($row['owner']);
                $username = $user->name;

                $row['owner_name'] = $username;
                $row['city'] = City::find($row['city'])->name;

                switch ($user->nation) {
                    case 0:
                        $nation = '';
                        break;
                    case 1:
                        $row['nation'] = 'római';
                        break;
                    case 2:
                        $row['nation'] = 'görög';
                        break;
                    case 3:
                        $row['nation'] = 'germán';
                        break;
                    case 4:
                        $row['nation'] = 'szarmata';
                        break;
                }
            }


            $row['nx'] = $nx;
            $row['ny'] = $ny;


            if ($nx == $view_width - 1) {
                $ny++;
                $nx = -1;
            }
        }

        return $grid;
    }


    /**
     * @param Request $request
     */
    public function ajaxArmy(Request $request)
    {

        if($request->input('army') == 0){
            return json_encode([
            'könnyűgyalogos' => 0,
            'nehézgyalogos' => 0,
            'pikás' => 0,
            'könnyűlovas' => 0,
            'nehézlovas' => 0,
            'íjász' => 0,
            'katapult' => 0
        ]);

        }

        $army = Army::where('id', $request->input('army'))->first();


//


//        if($city->hex->army_id > 0) {
            $units = [
//                'telepes' => $city->resources->settlers,
                'könnyűgyalogos' => $army->unit1,
                'nehézgyalogos' => $army->unit2,
                'pikás' => $army->unit3,
                'könnyűlovas' => $army->unit4,
                'nehézlovas' => $army->unit5,
                'íjász' => $army->unit6,
                'katapult' => $army->unit7
            ];
//        }
        return json_encode($units);
    }
}
