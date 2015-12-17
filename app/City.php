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

    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    public function building_slot()
    {
        return $this->hasOne('App\BuildingSlot', 'city');
    }

    public function buildings()
    {
        return $this->hasMany('buildings', 'city_id');
    }

    public function resources()
    {
        return $this->hasOne('App\Resource', 'city');
    }

    public function human_resources()
    {
        return $this->hasOne('App\HumanResource', 'city');
    }

    public function task()
    {
        return $this->hasOne('App\Task', 'city_id');
    }

    /**
     * Finds out if the city has enough resources for the action.
     *
     * @param array $price
     * @return array $resources
     */
    public function hasEnoughResources(array $price)
    {
        $resources = [];
        foreach ($price as $key => $value) {
            if ($this->resources->$key < $value) {
                // calculate the difference between the price and the current amount of resource
                $resources[$key] = $value - $this->resources->$key;
            }
        }
        return $resources;
    }

    /**
     * @param array $price
     * @return bool
     */
    public function hasEnoughHumanResources(array $price)
    {
        foreach ($price as $key => $value) {
            if ($this->human_resources->$key < $value) {
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

    public static $city_storage = [
        1 => 100,
        2 => 100,
        3 => 100,
        4 => 100,
    ];

}
