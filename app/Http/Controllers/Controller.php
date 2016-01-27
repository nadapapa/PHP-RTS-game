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
use Illuminate\Database\Eloquent\Model;
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

// TODO these methods should go to a model or trait
// TODO there should be a CanLevelUp and a HasHealth interface and the appropriate models should implement those

    /**
     * @param City $city
     * @param $thing
     * @param array $price
     * @param $time
     * @return $this|bool
     */
    public function levelUp($city, Model $thing, array $price, $time)
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
     * @param City  $city
     * @param Model $thing
     * @param array $price
     * @param int   $time   seconds
     * @param int   $health
     *
     * @return $this|bool
     */
    public function heal(City $city, Model $thing, array $price, $time, $health)
    {
        /** @var int $health */
        if ($thing->health + $health > 100) {
            return redirect("city/$city->id")->withErrors(['too_much_health' => '100%-nál nem lehet nagyobb']);
        }

        $thing->health += $health;
        /** @var int $time seconds*/
        $thing->finished_at = Carbon::now()->addSeconds($time);
        $city->resources->subtract($price);
        $thing->save();
        return true;
    }


}




