<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class HumanResource extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'human_resources';


    /**
     * @var array
     */
    protected $fillable = ['city_id', 'population', 'workers', 'settlers'];


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


    public static $general_price = [
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

    public static $general_time = [
        1 => 60,
        2 => 60,
        3 => 60,
        4 => 60,
    ];



}
