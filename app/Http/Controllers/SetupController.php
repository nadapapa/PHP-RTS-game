<?php

namespace App\Http\Controllers;

use App\BuildingSlot;
use App\City;
use App\Grid;
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
        $user->setNation($nation);

        $hex_id = Grid::randomHex()->id;

        $name = $request->input('name');
        City::create([
            'name' => $name,
            'nation' => $user->nation,
            'capital' => true,
            'owner' => $user->id,
            'hex_id' => $hex_id,
        ]);

        return redirect('home');
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'nation' => 'required|max:1',
            'name' => 'required|max:255|unique:cities',
        ]);
    }

}
