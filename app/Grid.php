<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
    protected $fillable = ['id', 'x', 'y', 'type', 'owner', 'city_id', 'army_id'];

    /**
     * The hex types which are inhabitable i.e. city can not be founded on.
     *
     * @var array
     */
    private static $inhabitable = [0, 1, 4, 5, 6, 7, 8, 9, 10, 11];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function army()
    {
        return $this->belongsTo('App\Army');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
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
    private static $map_dimensions = ['x' => 39, 'y' => 39];



    /**
     * Returns a random hex from the map. Only habitable hexes can be chosen.
     *
     * @return Grid $hex
     */
    public static function randomHex()
    {
        $optimal = false;

        /** @var Collection $grid */
        $grid = DB::table('grid')->whereNotIn('type', Grid::$inhabitable)->get();

        while ($optimal === false) {

            /** @var Grid $hex */
            $hex = $grid->random();

            if ($hex->x == 0 ||
                $hex->x == Grid::$map_dimensions['x'] ||
                $hex->y == 0 ||
                $hex->y == Grid::$map_dimensions['y']) {
                continue;
            }
            $optimal = $hex->checkNeighbors();
        }

        /** @var Grid $hex */
        return $hex;
    }


    /**
     * checks the current hex's neighbors if they have owner
     *
     * @param Grid $hex
     * @return bool
     */
    public function checkNeighbors()
    {
        /** @var Grid $neighbor */
        foreach ($this->neighbors() as $neighbor) {
            if ($neighbor->owner > 0) {
                return false;
            } else {
                return true;
            }
        }
    }


    /**
     * returns an array containing the current hex neighbors.
     *
     * @return array
     */
    private function neighbors()
    {
        $x = $this->x;
        $y = $this->y;

        $directions = [
            0 => [
                1 => ['x' => +1, 'y' => 0],
                2 => ['x' => +1, 'y' => -1],
                3 => ['x' => 0, 'y' => -1],
                4 => ['x' => -1, 'y' => -1],
                5 => ['x' => -1, 'y' => 0],
                6 => ['x' => 0, 'y' => +1]
            ],

            1 => [
                1 => ['x' => +1, 'y' => +1],
                2 => ['x' => +1, 'y' => 0],
                3 => ['x' => 0, 'y' => -1],
                4 => ['x' => -1, 'y' => 0],
                5 => ['x' => -1, 'y' => +1],
                6 => ['x' => 0, 'y' => +1]
            ],
        ];

        $parity = $x & 1;

        $neighbors = [];

        foreach ($directions[$parity] as $dir) {
            $nx = $x + $dir['x'];
            $ny = $y + $dir['y'];

            /** @var Grid $neighbor */
            $neighbor = Grid::where('x', $nx)->where('y', $ny)->first();

            if ($neighbor !== null){
                array_push($neighbors, $neighbor);
            }
        }
        return $neighbors;
    }

    /**
     *
     * @param $user_id
     */
    public function setNeighborsOwner($user_id)
    {
        /** @var Grid $neighbor */
        foreach ($this->neighbors() as $neighbor) {
            $neighbor->update(['owner' => $user_id]);
        }
    }
}
