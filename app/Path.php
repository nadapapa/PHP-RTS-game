<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paths';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path_id', 'hex_id', 'started_at', 'finished_at'];

    protected $dates = ['started_at', 'finished_at'];

    public $timestamps = false;


    public function army()
    {
        return $this->belongsTo('App\Army', 'path_id', 'path_id');
    }

    public function task()
    {
        return $this->belongsTo('App\Task', 'path_id');
    }

    public function hex()
    {
        return $this->hasOne('App\Grid', 'id', 'hex_id');
    }
}
