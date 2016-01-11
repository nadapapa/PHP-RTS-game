<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    // currently not used!

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'battles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hex_id', 'army1', 'army2', 'started_at', 'finished_at'];

    protected $dates = ['finished_at', 'started_at', 'created_at', 'updated_at'];


    public function hex()
    {
        $this->hasOne('App\Grid', 'battle_id', 'hex_id');
    }

    public function army1()
    {
        $this->hasOne('App\Army', 'battle_id', 'army1');
    }

    public function army2()
    {
        $this->hasOne('App\Army', 'battle_id', 'army2');
    }

}
