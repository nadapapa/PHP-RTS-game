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
        $username = Auth::user()->name;
        $cities = Auth::user()->cities;

        TaskController::checkTasks();

        return view('home', [
            'username' => $username,
            'cities' => $cities,
            'help' => '/help/home']);
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
