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

        return view('home', ['username' => $username, 'cities' => $cities]);
    }
}
