<?php

namespace App\Http\Controllers;

use App\City;
use App\Grid;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MapController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMap()
    {
         $grid = Grid::all()->toArray();
         $users = User::all();
         $cities = City::all();

        foreach ($grid as &$row) {
            if ($row['owner'] > 0) {
                $user = $users->where('id', $row['owner'])->first();
                $username = $user->name;

                $city = $cities->where('hex_id', $row['id'])->first();
                $cityname = $city->name;

                $nation = $city->nation;

                $row['owner_name'] = $username;
                $row['city'] = $cityname;
                $row['nation'] = $nation;
            }
        };

//        $grid->toArray();
//
        return view('map', ['grid' => $grid]);
    }
}
