<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'buildings';

    protected $dates = array('finished_at');

    protected $fillable = ['type', 'city', 'slot', 'nation', 'finished_at'];


    public static $building_prices = [
        '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
        '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
        '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
        '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
        '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
        '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
    ];
    public static $building_times = [
        '1' => 1,
        '2' => 1,
        '3' => 1,
        '4' => 1,
        '5' => 1,
        '6' => 1
    ];

    public $building_workers = [

    ];

    public $building_names = [
        '1' => 'Farm',
        '2' => 'Kőfejtő',
        '3' => 'Barakk',
        '4' => 'Favágó',
        '5' => 'Bánya',
        '6' => 'Raktár'
    ];

    public $building_description = [
        '1' => 'Élelmiszert termel',
        '2' => 'Követ termel',
        '3' => 'Katonákat termel',
        '4' => 'Fát termel',
        '5' => 'Vasat termel'
    ];
}
