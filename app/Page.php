<?php

/**
 * This model handels the pages
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = ['title','content','template'];

    /*****************
     * Relationships
     * **************/

    public function template()
    {
        return $this->belongsTo('App\Template');
    }

    public function parent()
    {
        return $this->belongsTo('App\Page', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Page', 'parent_id');
    }

    // Many to Many
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //Polymorphic one to one
    public function slug()
    {
        return $this->morphOne('App\Slug', 'slugable');
    }

    //polymorphic many to many relation
    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    



}
