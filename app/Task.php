<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_name'
    ];


    /**
     * A task type can be done in many travel claim.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travelClaims()
    {
        return $this->hasMany('\App\Travelclaim','task_id');
    }

}
