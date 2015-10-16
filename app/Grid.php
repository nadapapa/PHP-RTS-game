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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
