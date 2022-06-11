<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'published_at',
        'user_id'//temporary
    ];

    /*
     * Make the date to Laravel format
     * find getDates() in Illuminate\Database\Eloquent\Model.php
     */
    protected $dates = ['published_at'];

    /**
     * Scope queries to articles that have been published.
     *
     * @param $scope
     */
    public function scopePublished($scope)
    {
        $scope->where('published_at','<=',Carbon::now());
    }

    /**
     * Scope queries to articles that havent been published.
     *
     * @param $scope
     */
    public function scopeunPublished($scope)
    {
        $scope->where('published_at','>',Carbon::now());
    }

    /**
     * Set the published_at attribute.
     *
     * @param $date
     */
    public function setPublishedAtAttribute($date)
    {
        //$this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d',$date); //take $date plus now time
        $this->attributes['published_at'] = Carbon::parse($date);  //take $date plus now time(00:00:00)
    }

    /**
     * Get the published_at attribute
     * @param $date
     * @return string
     */
    public function getPublishedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }


    /**
     * An article is owned by a user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    /**
     * Get the tags associate with given article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('\App\Tag')->withTimestamps();
    }

    /**
     * Get a list of tag ids associated with the current article.
     *
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->lists('id');
    }
}
