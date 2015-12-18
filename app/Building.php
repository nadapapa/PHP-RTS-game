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

    protected $fillable = ['type', 'city_id', 'slot', 'nation', 'finished_at'];

    //----------------------------------------------------------------------------

    public static $building_names = [
        1 => [ // római
            '1' => 'Farm',
            '2' => 'Kőfejtő',
            '3' => 'Bánya',
            '4' => 'Favágó',
            '5' => 'Barakk',
            '6' => 'Raktár',
            '7' => 'Fórum',
            '8' => 'Kovács',
            '9' => 'Fal',

        ],
        2 => [ // görög
            '1' => 'Farm',
            '2' => 'Kőfejtő',
            '3' => 'Bánya',
            '4' => 'Favágó',
            '5' => 'Barakk',
            '6' => 'Raktár',
            '7' => 'Fórum',
            '8' => 'Kovács',
            '9' => 'Fal',
        ],
        3 => [ // germán
            '1' => 'Farm',
            '2' => 'Kőfejtő',
            '3' => 'Bánya',
            '4' => 'Favágó',
            '5' => 'Barakk',
            '6' => 'Raktár',
            '7' => 'Fórum',
            '8' => 'Kovács',
            '9' => 'Fal',
        ],
        4 => [ // szarmata
            '1' => 'Farm',
            '2' => 'Kőfejtő',
            '3' => 'Bánya',
            '4' => 'Favágó',
            '5' => 'Barakk',
            '6' => 'Raktár',
            '7' => 'Fórum',
            '8' => 'Kovács',
            '9' => 'Fal',
        ],
    ];

    // building prices for a level 1 building
    public static $building_prices = [
        1 => [ // római
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '8' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '9' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],

        ],
        2 => [ // görög
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '8' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '9' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
        ],
        3 => [ // germán
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '8' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '9' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
        ],
        4 => [ // szarmata
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '8' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '9' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
        ],
    ];

    // building times for a level 1 building in seconds
    public static $building_times = [
        1 => [ // római
            '1' => 60,
            '2' => 60,
            '3' => 60,
            '4' => 60,
            '5' => 60,
            '6' => 60,
            '7' => 60,
            '8' => 60,
            '9' => 60
        ],
        2 => [ // görög
            '1' => 60,
            '2' => 60,
            '3' => 60,
            '4' => 60,
            '5' => 60,
            '6' => 60,
            '7' => 60,
            '8' => 60,
            '9' => 60
        ],
        3 => [ // germán
            '1' => 60,
            '2' => 60,
            '3' => 60,
            '4' => 60,
            '5' => 60,
            '6' => 60,
            '7' => 60,
            '8' => 60,
            '9' => 60
        ],
        4 => [ // szarmata
            '1' => 60,
            '2' => 60,
            '3' => 60,
            '4' => 60,
            '5' => 60,
            '6' => 60,
            '7' => 60,
            '8' => 60,
            '9' => 60
        ],

    ];

    public static $building_description = [
        1 => [ // római
            '1' => 'Élelmiszert termel',
            '2' => 'Követ termel',
            '3' => 'Vasat termel',
            '4' => 'Fát termel',
            '5' => 'Katonákat termel',
            '6' => 'Raktároz',
            '7' => 'Munkást és telepest termel',
            '8' => 'A fegyverzetet és a páncélzatot fejleszti',
            '9' => 'A várost védi'
        ],
        2 => [ // görög
            '1' => 'Élelmiszert termel',
            '2' => 'Követ termel',
            '3' => 'Vasat termel',
            '4' => 'Fát termel',
            '5' => 'Katonákat termel',
            '6' => 'Raktároz',
            '7' => 'Munkást és telepest termel',
            '8' => 'A fegyverzetet és a páncélzatot fejleszti',
            '9' => 'A várost védi'
        ],
        3 => [ // germán
            '1' => 'Élelmiszert termel',
            '2' => 'Követ termel',
            '3' => 'Vasat termel',
            '4' => 'Fát termel',
            '5' => 'Katonákat termel',
            '6' => 'Raktároz',
            '7' => 'Munkást és telepest termel',
            '8' => 'A fegyverzetet és a páncélzatot fejleszti',
            '9' => 'A várost védi'
        ],
        4 => [ // szarmata
            '1' => 'Élelmiszert termel',
            '2' => 'Követ termel',
            '3' => 'Vasat termel',
            '4' => 'Fát termel',
            '5' => 'Katonákat termel',
            '6' => 'Raktároz',
            '7' => 'Munkást és telepest termel',
            '8' => 'A fegyverzetet és a páncélzatot fejleszti',
            '9' => 'A várost védi'
        ],
    ];


    public function task()
    {
        return $this->hasMany('App\Task', 'building_id');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }


}
