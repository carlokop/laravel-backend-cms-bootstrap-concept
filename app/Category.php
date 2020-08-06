<?php

/**
 * The category model handels all types of categories
 * This model is setup as polymorphic many to many
 * At the moment only Faq's have a polymorphic relation but other models can be added in a later time
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    /****************************************
     * Relations
     * **************************************/

    // polymorphic one to one relation
    public function slug()
    {
        return $this->morphOne('App\Slug', 'slugable');
    }

    //Polymorphic many to many

    public function posts()
    {
        return $this->morphedByMany('App\Post', 'categoryable');
    }
}
