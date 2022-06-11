<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Travelclaim extends Model {


    public $table = "travelClaim";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'startTime',
        'endTime',
        'hour',
        'travelDesc',
        'mileage',
//        'totalClaim',
        'flag',
        'rejectReason',
        'fm_rejectReason',
//        'plate_id'

    ];
    /**
     * Each  travel claim belong to claim
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function claims()
    {
        return $this ->belongsTo ('\App\Claim') ;
    }


    /**
     * Get the task type done during travel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tasks()
    {
        return $this -> belongsTo ('\App\Task','task_id');
    }

}
