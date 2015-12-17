<?php namespace App\Http\Controllers;

use App\Army;
use App\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

    /**
     * calculates and saves the production of a city during a time interval.
     * the time interval is the change of the resources table and the current time.
     *
     * @param City $city
     * @return array
     */
    public static function processProduction(City $city)
    {
        $resources = $city->resources;
        $now = Carbon::now();

        $production = self::calculateProduction($city); // production/hour

        $production['food'] -= self::calculateFoodConsumption($city, $production);//subtract consumption

        $time = $resources->updated_at->diffInSeconds($now);

        $time_prod = []; // the overall production

        foreach ($production as $key => $prod) {
            if ($prod == 0) { // if the prod is 0, there is no change so continue
                continue;
            }
            $time_prod[$key] = number_format(($prod * ($time / 3600)), 2);
        }

        // check if the city has enough storage
        $storage = self::calculateCityStorage($city);

        $production['population'] = 0;

        foreach ($time_prod as $key => $value) {
            $new_resource_value = $resources->$key + $value;

            // check if the new amount of resources are higher than the storage.
            // if higher than the maximum storage value is saved in the database.
            if ($new_resource_value >= $storage) {
                $resources->$key = $storage;
//                $time_prod[$key] = $storage;
            } else {
                if ($key == 'food' && ($resources->food <= 0 || $new_resource_value <= 0)) {
                    // if there's a negative food production or a food shortage
                    $production['population'] = self::calculatePopulationLoss($city, $production, $time);
                } elseif ($key == 'food' && ($resources->food > 0 || $new_resource_value > 0)) {
                    // if there's a positive food production or a food abundance
                    $production['population'] = self::calculatePopulationGain($city, $production, $time);
                }
                // if lower than the current production value is saved.
                $resources->$key = $new_resource_value;
//                $time_prod[$key] = $new_resource_value;
            }

        }

        $resources->save();
//        var_dump($resources);
        return $production;
    }


    /**
     * calculates the population loss based on time elapsed and quantity of food in the storage.
     * it saves the results directly to human_resources table
     *
     * @param City $city
     * @param array $production
     * @param $time
     */
    public static function calculatePopulationLoss(City $city, array $production, $time)
    {
        $t = ((0 - $city->resources->food) / $production['food']) * 3600;
        // a linear equation calculating the moment, when the food is 0.
        // $t is the time elapsed from the "updated_at" timestamp until the food reaches 0.
        // if $t is negative it means that the zero moment was before the updated_at.
        // if $t is positive it means that the zero moment was after the updated_at.
        // $t is in seconds

//        echo ($t) . ' t1<br>';

        if ($t > 0) {
            if (($t) < $time) { // if the zero moment has happened between updated_at and now.
                $time_diff = $time - $t; // $time_diff is the time difference between the now and the moment the food crosses the 0.
//                echo $time . ' time1 <br>';
//                echo number_format(($time_diff / 3600), 3) . ' timediff1<br>';
                $city->human_resources->population -= number_format(($time_diff / 3600), 3);
            } else { // if the zero moment will happen in the future
                // then the population loss is based on the time between updated_at and now
                $city->human_resources->population -= number_format(($time / 3600), 3);

            }
        } else { // means that the zero moment has happened before the updated_at.
            // then the population loss is based on the time between updated_at and now

//            echo (number_format(($time / 3600), 3) * $production['food']) . ' ptime1 <br>';

            $city->human_resources->population -= number_format(($time / 3600), 3);

        }

        $city->human_resources->save();

        return -1;

    }


    /**
     * calculates the population gain based on time elapsed and quantity of food in the storage.
     * it saves the results directly to human_resources table
     *
     * @param City $city
     * @param array $production
     * @param $time
     */
    public static function calculatePopulationGain(City $city, array $production, $time)
    {
        $t = ((0 - $city->resources->food) / $production['food']) * 3600;
        // a linear equation calculating the moment, when the food is 0.
        // $t is the time elapsed from the "updated_at" timestamp until the food reaches 0.
        // if $t is negative it means that the zero moment was before the updated_at.
        // if $t is positive it means that the zero moment was after the updated_at.
        // $t is in seconds

//        echo ($t) . ' t2<br>';

        if ($t > 0) {
            if ($t < $time) { // if the zero moment has happened between updated_at and now.
                $time_diff = $time - $t; // $time_diff is the time difference between the now and the moment the food crosses the 0.
//                echo $time . ' time2<br>';
//                echo number_format(($time_diff / 3600), 3) . ' timediff2<br>';

                $city->human_resources->population += number_format(($time_diff / 3600), 3);
            } else { // if the zero moment will happen in the future
                // then the population gain is based on the time between updated_at and now.
                $city->human_resources->population += number_format(($time / 3600), 3);

            }
        } else { // means that the zero moment has happened before the updated_at.
            // this means that it has been already calculated
            // in this case the population growth is based on the time between updated_at and now.

//            echo (number_format(($time / 3600), 3) * $production['food']) . ' ptime2 <br>';

            $city->human_resources->population += number_format(($time / 3600), 3);

        }

        $city->human_resources->save();
        return 1;
    }


    /**
     * calculates the hourly production of all production buildings in a particular city.
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

    /**
     * calculates the cities food consumption based on the garrisoned army units.
     *
     * @param City $city
     * @param array $production
     * @return int
     */
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

    /**
     * calculates the storage of the city based on the number and level of the stores.
     * only those matter with workers in it.
     *
     * @param City $city
     * @return int
     */
    public static function calculateCityStorage(City $city)
    {
        $now = Carbon::now();
        $storage = 0;
        $stores = $city->building_slot->building
            ->where('type', 6)
            ->where('finished_at', '>=', $now)
            ->where('workers', '>', 0);

        if (!$stores->isEmpty()) {
            $stores->toArray();
            foreach ($stores as $store) {
                $storage += ($store['level'] * 100) * ($store['health'] / 100);
            }

        }

        $storage += City::$city_storage[$city->nation];

        return $storage;

    }

}
