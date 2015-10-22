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
        $name = Auth::user()->name;
        $id = Auth::user()->id;
        $city = City::where('owner', $id)->first();


        return view('home', ['name' => $name, 'city' => $city]);
    }
}
