<?php namespace App\Http\Controllers;

use App\Building;
use App\BuildingSlot;
use App\City;
use App\Grid;
use App\HumanResource;
use App\Resource;
use App\Task;
use App\User;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
	use DispatchesCommands, ValidatesRequests;


// TODO these methods should go to the model

    /**
     * Finds out if the logged in user is the owner of the city.
     *
     * @param $city_id
     * @return bool
     */
    public function validateOwner($city)
    {
//        $city = City::find($city_id);
        $userid = Auth::user()->id;

        try {
            if ($city->owner !== $userid) {
                return false;
            }
        } catch (ErrorException $e) {
            return false;
        }
        return true;
    }


    /**
     * @param City $city
     * @param $thing
     * @param array $price
     * @param $time
     * @return $this|bool
     */
    public function levelUp($city, $thing, array $price, $time)
    {
        $lack_resource = $city->hasEnoughResources($price);
        if (empty($lack_resource)) {
            $thing->level += 1;
            $thing->finished_at = Carbon::now()->addSeconds($time);
            $city->resources->subtract($price);
            $thing->save();
        }

        $messages = [];
        $resources = [
            'stone' => 'kő',
            'lumber' => 'fa',
            'food' => 'élelmiszer',
            'iron' => 'vas'
        ];
        foreach ($lack_resource as $key => $value) {
            $messages["not_enough_$key"] = "Még $value $resources[$key] hiányzik";
        }

        return redirect()->back()->withErrors($messages);
    }


    /**
     * @param $city
     * @param $thing
     * @param $price
     * @param $time
     * @param $health
     * @return $this|bool
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




