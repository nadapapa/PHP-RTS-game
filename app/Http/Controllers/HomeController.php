<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     *
     */
    public function getHome()
    {
        $user = Auth::user();
        $username = $user->name;
        $cities = Auth::user()->cities;

        TaskController::checkTasks();

        $productions = [];

        if(!count($cities)) {
           // TODO if the user has not got any city.
        }
            foreach ($cities as $city) {
                $productions[$city->id] = ResourceController::processProduction($city);
            }


        $armies = $user->armies;

        $coords = [];

        foreach ($armies as $army) {
            $coords[$army->id] = ['x' => $army->currentHex->x, 'y' => $army->currentHex->y];
        }


        return view('home', [
            'username' => $username,
            'cities' => $cities,
            'help' => '/help/home',
            'productions' => $productions,
            'armies' => $armies,
            'coords' => $coords,
        ]);
    }

    public function getHelp($help = 0)
    {
        switch ($help) {
            case 'map':
                return view('help/map_help');
            case 'home':
                return view('help/home_help');
            case 'city':
                return view('help/city_help');
            case 0:
                return view('help/help');
        }
    }

    public function getSettings()
    {
        return view('settings');
    }
}
