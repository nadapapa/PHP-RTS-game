<?php namespace App\Http\Controllers;

use App\Army;
use App\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

    public static function processProduction(City $city)
    {
        $resources = $city->resources;
        $now = Carbon::now();

        $production = self::calculateProduction($city);

        $production['food'] -= self::calculateFoodConsumption($city, $production);

        $time = $resources->updated_at->diffInSeconds($now);

        $time_prod = [];

        foreach ($production as $key => $prod) {
            $time_prod[$key] = number_format(($prod * ($time / 3600)), 2);
        }

        // check if the city has enough storage
        $storage = 0;
        $stores = $city->building_slot->building->where('type', 6);
        if (!$stores->isEmpty()) {
            $stores->toArray();
// TODO megcsinálni a raktáras részt
        }

        $storage += City::$city_storage[$city->nation];
        var_dump($storage);

        return $production;
    }


    /**
     * calculates the production of all production buildings in a particular city.
     * production = (level of building * number of workers in the building) % health of building
     *
     * @param City $city
     * @return array
     */
    public static function calculateProduction(City $city)
    {
        $production = [
            'food' => 0,
            'iron' => 0,
            'lumber' => 0,
            'stone' => 0
        ];

        foreach ($city->building_slot->building as $building) {
            $profit = ($building->level * $building->workers) * ($building->health / 100);

            switch ($building->type) {
                case 1:
                    $production['food'] += $profit;
                    break;
                case 2:
                    $production['stone'] += $profit;
                    break;
                case 3:
                    $production['iron'] += $profit;
                    break;
                case 4:
                    $production['lumber'] += $profit;
                    break;
            }
        }

        return $production;

    }

    public static function calculateFoodConsumption(City $city, array $production)
    {
        $food_consumtion = 0;

        if ($army = $city->hex->army) {
            foreach ($army->getUnits() as $key => $unit) {
                $food_consumtion += Army::$unit_food_consumtion[$city->nation][$key] * $unit;
            }
            return $food_consumtion;
        } else {
            return $food_consumtion;
        }
    }

}
