<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'status',
        'month',
        'year',
        'total'
    ];


    /**
     * A claim belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {                                          //foreign key
        return $this ->belongsTo ('\App\User','user_id') ;
    }


    /**
     * A claim (Monthly) has many OT Claims
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function otclaim()
    {
        return $this ->hasMany ('\App\Otclaim') ;
    }

    /**
     * A claim (Monthly) has many Travel Claims
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travelclaim()
    {
        return $this ->hasMany ('\App\Travelclaim') ;
    }

}
