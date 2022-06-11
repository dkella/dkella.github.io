<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Otclaim extends Model {

    public $table = "otclaim";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'startTime',
        'endTime',
        'totalHour',
        'hourA',
        'hourB',
        'hourC',
        'hourD',
        'hourE',
        'otDesc',
        'totalClaim',
        'flag',
        'rejectReason',
        'fm_rejectReason',
        'isHoliday',
        'claim_id'

    ];

    /**
     * Each OT claim belong to one claim
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function claims()
    {
        return $this ->belongsTo ('\App\Claim') ;
    }

}
