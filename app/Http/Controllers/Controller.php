<?php namespace App\Http\Controllers;

use App\Building;
use App\BuildingSlot;
use App\City;
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



}
