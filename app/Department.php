<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department'
    ];

    /**
     * A department can have many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('\App\User','dept_id');
    }
}
