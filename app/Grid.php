<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'x', 'y', 'layer1', 'layer2', 'layer3', 'layer4', 'layer5', 'owner', 'city'];

    /**
     * The hex types which are inhabitable i.e. city can not be founded on.
     *
     * @var array
     */
    public static $inhabitable = [0, 1, 4, 5, 6, 7, 8, 9, 10, 11];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo('App\City', 'hex_id');
    }

    public function army()
    {
        return $this->belongsTo('App\Army');
    }


    public static $price = [
        1 => 10,    //1  wo     Medium Deep Water
        2 => 2,     //2  ds     Beach Sands
        3 => 1,     //3  gg     Green Grass
        4 => 3,     //4  Gs^Fp  Semi-dry Grass Pine Forest
        5 => 2,     //5  Aa     Snow
        6 => 3,     //6  Hh     Regular Hills
        7 => 3,     //7  ha     Snow Hills
        8 => 6,     //8  mm     Regular Mountains
        9 => 6,     //9  ww     Medium Shallow Water
        10 => 2,    //10 ai     Ice
        11 => 6,    //11 ss     Swamp Water Reed
    ];

}
