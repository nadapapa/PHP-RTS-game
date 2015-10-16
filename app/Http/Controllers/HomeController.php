<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function getHome()
    {
        return view('home');
    }


    /**
     * Assigns the selected nation to the user
     *
     * @param Request $nation
     *
     */
    public function postNation(Request $request)
    {
     $nation = $request->input('nation');
     $user = Auth::user();
     $user->nation = $nation;
     $user->save();
        return view('home');

    }
}
