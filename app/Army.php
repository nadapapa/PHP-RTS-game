<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Army extends Model
{

    public static $unit_names = [
        1 => [ // római
            1 => 'könnyűgyalogos',
            2 => 'nehézgyalogos',
            3 => 'pikás',
            4 => 'könnyűlovas',
            5 => 'nehézlovas',
            6 => 'íjász',
            7 => 'katapult'
        ],
        2 => [ // görög
            1 => 'könnyűgyalogos',
            2 => 'nehézgyalogos',
            3 => 'pikás',
            4 => 'könnyűlovas',
            5 => 'nehézlovas',
            6 => 'íjász',
            7 => 'katapult'
        ],
        3 => [ // germán
            1 => 'könnyűgyalogos',
            2 => 'nehézgyalogos',
            3 => 'pikás',
            4 => 'könnyűlovas',
            5 => 'nehézlovas',
            6 => 'íjász',
            7 => 'katapult'
        ],
        4 => [ // szarmata
            1 => 'könnyűgyalogos',
            2 => 'nehézgyalogos',
            3 => 'pikás',
            4 => 'könnyűlovas',
            5 => 'nehézlovas',
            6 => 'íjász',
            7 => 'katapult'
        ],
    ];

    public static $unit_prices = [
        1 => [ // római
            // light infantry
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // heavy infantry
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // pikeman
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // light cavalry
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // heavy cavalry
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // archer
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            // catapult
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
        ],
        2 => [ // görög
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
        ],
        3 => [ // germán
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
        ],
        4 => [ // szarmata
            '1' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '2' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '3' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '4' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '5' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '6' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10],
            '7' => ['iron' => 10, 'food' => 10, 'lumber' => 10, 'stone' => 10]
        ],
    ];

    public static $unit_times = [
        1 => [ // római
            1 => 60,
            2 => 60,
            3 => 60,
            4 => 60,
            5 => 60,
            6 => 60,
            7 => 60
        ],
        2 => [ // görög
            1 => 60,
            2 => 60,
            3 => 60,
            4 => 60,
            5 => 60,
            6 => 60,
            7 => 60
        ],
        3 => [ // germán
            1 => 60,
            2 => 60,
            3 => 60,
            4 => 60,
            5 => 60,
            6 => 60,
            7 => 60
        ],
        4 => [ // szarmata
            1 => 60,
            2 => 60,
            3 => 60,
            4 => 60,
            5 => 60,
            6 => 60,
            7 => 60
        ],
    ];

    public static $unit_speeds = [ // seconds/hex
        1 => [ // római
            1 => 60,
            2 => 80,
            3 => 70,
            4 => 30,
            5 => 50,
            6 => 60,
            7 => 100
        ],
        2 => [ // görög
            1 => 60,
            2 => 80,
            3 => 70,
            4 => 30,
            5 => 50,
            6 => 60,
            7 => 100
        ],
        3 => [ // germán
            1 => 60,
            2 => 80,
            3 => 70,
            4 => 30,
            5 => 50,
            6 => 60,
            7 => 100
        ],
        4 => [ // szarmata
            1 => 60,
            2 => 80,
            3 => 70,
            4 => 30,
            5 => 50,
            6 => 60,
            7 => 100
        ],
    ];

    public static $unit_food_consumtion = [ // food/hour
        1 => [ // római
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 1
        ],
        2 => [ // görög
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 1
        ],
        3 => [ // germán
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 1
        ],
        4 => [ // szarmata
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 1
        ],
    ];

    public static $unit_defense = [
        1 => [ // római
            1 => 1,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 2,
            6 => 1,
            7 => 1
        ],
        2 => [ // görög
            1 => 1,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 2,
            6 => 1,
            7 => 1
        ],
        3 => [ // germán
            1 => 1,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 2,
            6 => 1,
            7 => 1
        ],
        4 => [ // szarmata
            1 => 1,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 2,
            6 => 1,
            7 => 1
        ],
    ];

    public static $unit_attack = [
        1 => [ // római
            1 => 1,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 2,
            6 => 1,
            7 => 1
        ],
        2 => [ // görög
            1 => 1,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 2,
            6 => 1,
            7 => 1
        ],
        3 => [ // germán
            1 => 1,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 2,
            6 => 1,
            7 => 1
        ],
        4 => [ // szarmata
            1 => 1,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 2,
            6 => 1,
            7 => 1
        ],
    ];

    public static $unit_description = [
        1 => [ // római
            1 => "Leírás",
            2 => "Leírás",
            3 => "Leírás",
            4 => "Leírás",
            5 => "Leírás",
            6 => "Leírás",
            7 => "Leírás"
        ],
        2 => [ // görög
            1 => "Leírás",
            2 => "Leírás",
            3 => "Leírás",
            4 => "Leírás",
            5 => "Leírás",
            6 => "Leírás",
            7 => "Leírás"
        ],
        3 => [ // germán
            1 => "Leírás",
            2 => "Leírás",
            3 => "Leírás",
            4 => "Leírás",
            5 => "Leírás",
            6 => "Leírás",
            7 => "Leírás"
        ],
        4 => [ // szarmata
            1 => "Leírás",
            2 => "Leírás",
            3 => "Leírás",
            4 => "Leírás",
            5 => "Leírás",
            6 => "Leírás",
            7 => "Leírás"
        ],
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'armies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'current_hex_id', 'task_id', 'path_id', 'general'];


    public function currentHex()
    {
        return $this->hasOne('App\Grid', 'army_id');
    }

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function task()
    {
        return $this->hasOne('App\Task', 'army_id');
    }

    public function general()
    {
        return $this->belongsTo('App\General', 'army_id');
    }

    public function path()
    {
        return $this->hasMany('App\Path', 'path_id', 'path_id');
    }

    public function getUnits()
    {
        return [
            1 => $this->unit1,
            2 => $this->unit2,
            3 => $this->unit3,
            4 => $this->unit4,
            5 => $this->unit5,
            6 => $this->unit6,
            7 => $this->unit7
        ];
    }

    public function getUnitsSum()
    {
        $units = $this->getUnits();

        $sum = 0;
        foreach ($units as $key => $unit) {
            $sum += $unit;
        }

        return $sum;
    }

    /**
     * Calculates the sum of the attack points of the Army's units.
     *
     * @return int
     */
    public function calculateAttackingPoints()
    {
        // TODO include modifiers (armour and weapon upgrades) in the calculation

        $units = $this->getUnits();
        $points = 0;

        foreach ($units as $key => $unit) {
            if ($unit > 0) {
                $points += (Army::$unit_attack[$this->user->nation][$key] * $unit);
            }
        }

        return $points;
    }

    /**
     * Calculates the sum of the defense points of the Army's units.
     *
     * @return int
     */
    public function calculateDefensePoints()
    {
        // TODO include modifiers (armour and weapon upgrades) in the calculation

        $units = $this->getUnits();
        $points = 0;

        foreach ($units as $key => $unit) {
            if ($unit > 0) {
                $points += (Army::$unit_defense[$this->user->nation][$key] * $unit);
            }
        }

        return $points;
    }

    /**
     * Calculates the hourly food consumption of the army.
     * Currently every
     *
     * @return int
     */
    public function calculateFoodConsumption()
    {
        // TODO include modifiers (e.g. upgrades)
        $units = $this->getUnits();
        $food = 0;

        foreach ( $units as $key => $unit ) {
            $food += (Army::$unit_food_consumtion[$this->user->nation][$key] * $unit);
        }

        return $food;
    }

    /**
     * delete army and its path, task(s) and deletes its id from hex
     *
     * @param Army $army
     */
    public function destroyArmy()
    {
        if (count($this->task)){
            $this->task->delete();
        }

        if (count($this->path)){
            $this->path->each(function($path){
                $path->delete();
            });
        }

        $this->currentHex->update(['army_id' => 0]);
        $this->delete();
    }

    /**
     * TODO calculate casualties
     *
     *
     */
    public function calculateCasualties()
    {



    }

    /**
     * Chooses the winner army based on attack and defense points
     *
     * @param Army $attacking_army
     * @return void
     */
    public function processBattle(Army $attacking_army)
    {

        /**
         * attacking army's attack points
         *
         * @var int $attacking_attack
         */
        $attacking_attack = $attacking_army->calculateAttackingPoints();


        /**
         * attacked army's defense points
         *
         * @var int $attacked_defense
         */
        $attacked_defense = $this->calculateDefensePoints();

        // TODO include hex modifier in the calculation

        /** @var int $point */
        $point = $attacking_attack - $attacked_defense;

        if ($point === 0){ // it's a tie
            $point += rand(-1, 1); // randomly add or remove 1 so the $point will be 1 or -1
        }

        if ($point > 0){ // the attacking army wins
            /** @var Army $winner */
            $winner = $attacking_army;
            /** @var Army $loser */
            $loser = $this;
        } elseif ($point < 0) { // the attacked army wins
            /** @var Army $winner */
            $winner = $this;
            /** @var Army $loser */
            $loser = $attacking_army;
        }

//        TODO $this::calculateCasualties();

        /** @var Army $loser */
        $loser->destroyArmy();

        // TODO a pontok alapján kiszámolni a veszteségeket és ennek megfelelően módosítani a seregeket
        // jelenleg a vesztes sereg teljesen megsemmisül, a győztesnek nincs vesztesége és folytatja az útját
        // TODO a csata eredményét megjeleníteni a felhasználónak

    }


}
