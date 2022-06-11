<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the articles associated with the given tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Articles()
    {
        //return $this->belongsToMany('\App\Article',"tags_pivot","article_identifier"); //table name->tags_pivot single name?->article_identifier
        return $this->belongsToMany('\App\Article')->withTimestamps();
    }

}
