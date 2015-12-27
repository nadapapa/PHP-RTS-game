<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class General extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'generals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'army_id', 'food'];

    protected $dates = ['created_at', 'updated_at'];


    public function army()
    {
        $this->hasOne('App\Army');
    }



}
