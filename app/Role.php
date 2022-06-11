<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role'
    ];

    /**
     * A roles belongs to many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this ->belongsToMany ('\App\User') ;
    }

}
