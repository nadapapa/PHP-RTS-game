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
        $city = City::create([
            'name' => $name,
            'nation' => $user->nation,
            'capital' => $capital,
            'owner' => $user->id,
            'hex_id' => $hex_id,
        ]);

        $slot = BuildingSlot::create(['city' => $city->id]);
        Resource::create(['city' => $city->id]);
        HumanResource::create(['city' => $city->id]);

        $city->building_slot = $slot->id;
        $city->save();

        $wall = Building::create([
            'city_id' => $city->id,
            'slot' => $slot->id,
            'nation' => $user->nation,
            'type' => 9,
            'finished_at' => Carbon::now(),
        ]);

        $slot->wall = $wall->id;
        $slot->save();

        $hex = Grid::find($hex_id);
        $hex->update(['owner' => $user->id, 'city' => $city->id]);

        foreach ($this->hexNeighbors($hex) as $neighbor) {
//            $nhex = Grid::find($neighbor[0]['id']);
            $neighbor->update(['owner' => $user->id]);
        }

    }


    /**
     * Returns a random hex id. Only habitable hexes can be chosen.
     * The hex is not in the n
     * @return
     * @internal param array $habitable
     */
    public function randomHex()
    {
        $optimal = false;
        $grid = Grid::whereNotIn('layer1', Grid::$inhabitable)->get();

        while ($optimal === false) {
            $hex = $grid->random();

            if ($hex->x == 0 || $hex->x == 39 || $hex->y == 0 || $hex->y == 39) {
                continue;
            }

            foreach ($this->hexNeighbors($hex) as $neighbor) {
                if (empty($neighbor)) {
                    continue;
                }
                if ($neighbor->owner > 0) {
                    continue;
                } else {
                    $optimal = true;
                }
            }

        }

        return $hex->id;
    }

    /**
     * @param Grid $hex
     * @return bool
     */
    public function checkNeighbors(Grid $hex)
    {
        foreach ($this->hexNeighbors($hex) as $neighbor) {
            if (empty($neighbor)) {
                continue;
            }
            if ($neighbor[0]['owner'] > 0) {
                return false;
            } else {
                return true;
            }
        }

    }


    /**
     * @param Grid $hex
     * @return array
     */
    public function hexNeighbors(Grid $hex)
    {

        $x = $hex->x;
        $y = $hex->y;

        $directions = [
            0 => [
                1 => ['x' => +1, 'y' => 0],
                2 => ['x' => +1, 'y' => -1],
                3 => ['x' => 0, 'y' => -1],
                4 => ['x' => -1, 'y' => -1],
                5 => ['x' => -1, 'y' => 0],
                6 => ['x' => 0, 'y' => +1]
            ],

            1 => [
                1 => ['x' => +1, 'y' => +1],
                2 => ['x' => +1, 'y' => 0],
                3 => ['x' => 0, 'y' => -1],
                4 => ['x' => -1, 'y' => 0],
                5 => ['x' => -1, 'y' => +1],
                6 => ['x' => 0, 'y' => +1]
            ],
        ];

        $parity = $x & 1;

        $neighbors = [];

        foreach ($directions[$parity] as $dir) {

            $nx = $x + $dir['x'];
            $ny = $y + $dir['y'];

            $nhex = Grid::where('x', $nx)->where('y', $ny)->first();

            array_push($neighbors, $nhex);
        }
        return $neighbors;
    }
}




