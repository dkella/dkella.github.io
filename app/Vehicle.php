<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plateNo',
        'vehicleName',
        'engine',
        'class_id',
        'user_id'
    ];

    /**
     * One vehicle owned by an user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('\App\User');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function travelconfig()
    {
        return $this->belongsTo('\App\Travelconfig','class_id');
    }
}
