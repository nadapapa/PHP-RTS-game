<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'nation', 'capital', 'owner', 'hex_id', 'building_slots'];


    public function hex()
    {
        return $this->hasOne('App\Grid', 'city');
    }

    public function building_slot()
    {
        return $this->hasOne('App\BuildingSlot', 'city');
    }

    public function resources()
    {
        return $this->hasOne('App\Resource', 'city');
    }

    public function task()
    {
        return $this->hasOne('App\Task', 'city_id');
    }

    /**
     * Finds out if the city has enough resources for the action.
     *
     * @param City $city
     * @param array $price
     */
    public function hasEnoughResources(array $price)
    {
        foreach ($price as $key => $value) {
            if ($this->resources->$key < $value) {
                return false;
            }
        }
        return true;
    }

    public static $worker_price = [
        1 => [ // római
            'iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10
        ],
        2 => [ // görög
            'iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10
        ],
        3 => [ // germán
            'iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10
        ],
        4 => [ // szarmata
            'iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10
        ],
    ];

    public static $worker_time = [
        1 => 60,
        2 => 60,
        3 => 60,
        4 => 60,
    ];


    public static $settler_price = [
        1 => [ // római
            'iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10
        ],
        2 => [ // görög
            'iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10
        ],
        3 => [ // germán
            'iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10
        ],
        4 => [ // szarmata
            'iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10
        ],
    ];

    public static $settler_time = [
        1 => 60,
        2 => 60,
        3 => 60,
        4 => 60,
    ];


    public static $unit_prices = [
        1 => [ // római
            // worker
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // swordman
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // pikeman
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // horseman
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // archer
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
        ],
        2 => [ // görög
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
        ],
        3 => [ // germán
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
        ],
        4 => [ // szarmata
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
        ],
    ];
}
