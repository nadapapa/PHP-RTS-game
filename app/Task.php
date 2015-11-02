<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'user', 'city', 'building', 'finished_at'];

    protected $dates = array('finished_at');


    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function building()
    {
        return $this->belongsTo('App\Building');
    }

    private $types = [
        1 => 'create a worker',
        2 => 'create a unit'
    ];
}
