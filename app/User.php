<?php namespace App;

use Coderjp\Verifier\Traits\VerifierUserTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

	use Authenticatable, CanResetPassword, VerifierUserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'verified'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * One-to-many relationship with City model
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function cities()
	{
		return $this->hasMany('App\City', 'owner');
	}

	public function grid()
	{
		return $this->hasMany('App\Grid', 'owner');
	}

    public function task()
    {
		return $this->hasOne('App\Task', 'user_id');
    }

    public function armies()
    {
        return $this->hasMany('App\Army', 'user_id');
    }

    // SETTERS

    /**
     * Assigns the selected nation to the user
     * 
     * @param $nation
     */
    public function setNation($nation)
	{
		$this->nation = $nation;
		$this->save();
	}

}
