<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Travelconfig extends Model {

    public $table = "travelConfig";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vehicleClass',
        'description',
        'rateA',
        'rateB',
        'rateC',
        'rateD'
    ];

    public function vehicle()
    {
        return $this->hasMany('\App\Vehicle','class_id');
    }
}
