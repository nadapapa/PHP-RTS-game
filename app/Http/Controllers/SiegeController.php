<?php namespace App\Http\Controllers;

use App\Army;
use App\Http\Controllers\ArmyController;
use App\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SiegeController extends Controller {

	public static function processSiege(Army $army, City $city)
	{
        // TODO check if the army has catapult
        // TODO message users about the result
        $attack_point = $army->calculateAttackingPoints();
        $defense_point = $city->calculateDefensePoints();

        if ($attack_point > $defense_point){ // attacker wins
            // the city becomes the attacker's city
            $city->update([
                'owner' => $army->user->id,
                'capital' => 0,
                'nation' => $army->user->nation
            ]);
            $city->hex->update(['owner' => $army->user->id]);


        }
        elseif ($attack_point < $defense_point){ // defender wins
            $army->destroyArmy();
        }

	}

    public static function calculateCityLoss()
    {
        // TODO calculate wall and building damage

    }
}
