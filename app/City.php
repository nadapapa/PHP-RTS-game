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
        return $this->hasOne('App\Grid', 'city', 'hex_id');
    }

    public function building_slot()
    {
        return $this->hasOne('App\BuildingSlot', 'city');
    }

    public function resources()
    {
        return $this->hasOne('App\Resource', 'city');
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

}
