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

        foreach ($grid as &$row) {
            if ($row['owner'] > 0) {
                $user = User::find($row['owner']);
                $username = $user->name;

                $city = City::find($row['city']);
                $cityname = $city->name;

                $nation = $city->nation;

                $row['owner_name'] = $username;
                $row['city'] = $cityname;
                $row['nation'] = $nation;
            }
        };

        return view('map', ['grid' => $grid]);
    }
}
