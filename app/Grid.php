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
    public static $inhabitable = [0, 1, 10, 21, 22];

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
}
