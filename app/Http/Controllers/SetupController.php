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

    /**
     * creates a new city
     *
     * @param User $user
     * @param int $capital
     * @param int $hex_id
     * @param string $name
     */
    public function createCity(User $user, $capital, $hex_id, $name)
    {
//        $fillable = ['name', 'nation', 'capital', 'owner', 'hex_id'];
        $city = City::create([
            'name' => $name,
            'nation' => $user->nation,
            'capital' => $capital,
            'owner' => $user->id,
            'hex_id' => $hex_id,
        ]);

        BuildingSlot::create(['city' => $city->id]);
        Resource::create(['city' => $city->id]);

        $hex = Grid::find($hex_id);
        $hex->update(['owner' => $user->id, 'layer2' => 100, 'city' => $city->id]);
    }

    /**
     * Returns a random hex id. Only habitable hexes can be chosen.
     *
     * @param array $habitable
     * @return
     */
    public function randomHex()
    {
        $inhabitable = Grid::$inhabitable;
        $grid = Grid::whereNotIn('layer1', $inhabitable)->get();
        $hex = $grid->random();
        $hex->update(['type' => 100]);
        return $hex->id;
    }
}
