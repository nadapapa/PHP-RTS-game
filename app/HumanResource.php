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

}
