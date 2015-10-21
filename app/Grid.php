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
    protected $fillable = ['id', 'x', 'y', 'type', 'owner'];

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
}
