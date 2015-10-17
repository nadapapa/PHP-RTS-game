<?php

namespace App\Http\Controllers;

use App\City;
use App\Grid;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;

class SetupController extends Controller
{

    public function getSetup()
    {

        return view('user.validated');
    }


    /**
     * Sets up the user and the city for the game
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function postSetup(Request $request)
    {
        $user = Auth::user();


        $nation = $request->input('nation');
        $this->setNation($user, $nation);


        $hex_id = $this->randomHex();

        $name = $user->name." városa";
        $this->createCity($user, 1, $hex_id, $name);

        return redirect('home');
    }


    /**
     * Assigns the selected nation to the user
     */
    public function setNation(User $user, $nation)
    {
//        $nation = $request->input('nation');

        $user->nation = $nation;
        $user->save();
    }

    /**
     * @param $user
     */
    public function createCity(User $user, $capital, $hex_id, $name)
    {
//        $fillable = ['name', 'nation', 'capital', 'owner', 'hex_id'];
        City::create([
            'name' => $name,
            'nation' => $user->nation,
            'capital' => $capital,
            'owner' => $user->id,
            'hex_id' => $hex_id,
        ]);
    }

    /**
     *
     */
    public function randomHex()
    {
        $grid = Grid::where('type', 0)->orWhere('type', 4)->get();
        $hex = $grid->random();
        return $hex->id;

    }
}
