<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Otconfig extends Model {

    public $table = "otconfig";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'typeOT',
        'description',
        'rate'

    ];

}
