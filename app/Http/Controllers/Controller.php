<?php namespace App\Http\Controllers;

use App\Building;
use App\BuildingSlot;
use App\City;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{

	use DispatchesCommands, ValidatesRequests;

	/**
	 * Finds out if the logged in user is the owner of the city.
	 *
	 * @param $city_id
	 * @return $this|\Illuminate\Support\Collection|null|static
	 */
	public function validateOwner($city_id)
	{
		$city = City::find($city_id);
		$userid = Auth::user()->id;

		try {
			if ($city->owner != $userid) {
				return redirect('/home')->withErrors('Ez nem a te városod');
			}
		} catch (ErrorException $e) {
			return redirect('/home')->withErrors(['Nincs ilyen város']);
		}

		return $city;
	}


    /**
     * @param City $city
     * @param $thing
     * @param array $price
     */
    public function levelUp($city, $thing, array $price, $time)
    {
        if ($city->hasEnoughResources($price)) {
            $thing->level += 1;
            $thing->finished_at = Carbon::now()->addSeconds($time);
            $city->resources->subtract($price);
            $thing->save();
            return true;
        }
        return redirect("city/$city->id")->withErrors(['not_enough_resources' => 'Nincs elég nyersanyag']);
    }


    /**
     * @param $city
     * @param $thing
     * @param $price
     * @param $time
     */
    public function heal($city, $thing, $price, $time, $health)
    {
        if ($thing->health + $health > 100) {
            return redirect("city/$city->id")->withErrors(['too_much_health' => '100%-nál nem lehet nagyobb']);
        }
        $thing->health += $health;
        $thing->finished_at = Carbon::now()->addSeconds($time);
        $city->resources->subtract($price);
        $thing->save();
        return true;
    }
}
