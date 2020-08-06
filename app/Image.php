<?php

/**
 * This model handels all images
 * There is a polymorphic relation to all models that require images
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name',
        'title',
        'alt'
    ];

    /*****************
     * Relationships
     * **************/

    //one to many with imageFiles
    public function imagefiles()
    {
        return $this->hasMany('App\ImageFile');
    }

     //Polymorphic many to many
    public function pages()
    {
        return $this->morphedByMany('App\Page', 'imageable');
    }

    public function posts()
    {
        return $this->morphedByMany('App\Post', 'imageable');
    }

    

}
