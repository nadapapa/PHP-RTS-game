<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Resource
 * @package App
 */
class Resource extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'resources';


    /**
     * @var array
     */
    protected $fillable = ['city'];


    /**
     * Subtracts the building's or job's price.
     *
     * @param array $price
     */
    public function subtract(array $price)
    {
        foreach ($price as $key => $value) {
            $this->$key -= $value;
        }

        $this->save();
    }

    public function add(array $resources)
    {
        foreach ($resources as $key => $value) {
            $this->$key += $value;
        }

        $this->save();
    }
}
