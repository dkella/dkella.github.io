<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Identifier extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'type'
    ];

}
