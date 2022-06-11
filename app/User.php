<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

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
	protected $fillable = [
                            'name',
                            'noKP',
                            'position',
                            'dept_id',
                            'branch',
                            'homeAddress',
                            'salary',
                            'email',
                            'password'
                        ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    /**
     * A user can have many articles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('\App\Article');
    }

    public function isATeamManager()
    {
        return true; //true is manager,false is not manager
    }

    /**
     * An user has only one role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function roles()
    {
        return $this ->belongsToMany('\App\Role');
    }

    /**
     * Get the departments of user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departments()
    {
        return $this -> belongsTo ('\App\Department','dept_id');
    }

    /**
     * Get user's vehicle info
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehicles()
    {
        return $this->hasOne('\App\Vehicle');
    }

    /**
     * Get user's monthly claim
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function claims()
    {
        return $this ->hasMany('\App\Claim');
    }


//    public function supervisions()
//    {
////        return $this ->hasMany('\App\User','\App\User');
//    }

    public function theSupervisors()
    {
        return $this->belongsToMany('\App\User', 'supervision', 'staff_id', 'sv_id');
    }

// Same table, self referencing, but change the key order
    public function theStaffs()
    {
        return $this->belongsToMany('\App\User', 'supervision', 'sv_id', 'staff_id');
    }

}
