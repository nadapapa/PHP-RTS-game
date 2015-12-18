<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingSlot extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'building_slots';

    protected $fillable = ['city', 'wall', 'slot1', 'slot2', 'slot3', 'slot4', 'slot5', 'slot6', 'slot7', 'slot8', 'slot9', 'slot10', 'slot11', 'slot12', 'slot13', 'slot14', 'slot15', 'slot16', 'slot17', 'slot18', 'slot19', 'slot20', 'slot21', 'slot22', 'slot23', 'slot24', 'slot25'];

    public function city()
    {
        return $this->belongsTo('App\City', 'building_slots');
    }

    public function building()
    {
        return $this->hasMany('App\Building', 'slot');
    }

    public function wall()
    {
        return $this->hasOne('App\Building', 'slot', 'wall');
    }

}
