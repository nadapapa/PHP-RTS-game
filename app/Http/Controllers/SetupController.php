<?php

namespace App\Http\Controllers;

use App\BuildingSlot;
use App\City;
use App\Grid;
use App\Resource;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Validator;

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
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = Auth::user();


        $nation = $request->input('nation');
        $this->setNation($user, $nation);


        $hex_id = $this->randomHex();

        $name = $request->input('name');
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

    protected function validator(array $data) {
        return Validator::make($data, [
            'nation' => 'required|max:1',
            'name' => 'required|max:255|unique:cities',
        ]);
    }

}
