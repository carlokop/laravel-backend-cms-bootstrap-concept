<?php

/*
* This model saves the slugs in the database
* Slugs in this model should be related to all models that have url's
* The path DB table is used in routes
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Padosoft\Sluggable\HasSlug;
use Padosoft\Sluggable\SlugOptions;

class Slug extends Model
{
    use HasSlug; 

    protected $fillable = [
        'path','homepage'
    ];

    /*****************
     * Relationships
     * **************/

    //Polymorphic  one to many
    public function slugable()
    {
        return $this->morphTo();
    }
    

    //sanitizes the slug
    //run this function before saving the slug
    public function cleanup() {
        $slug = preg_replace('~[^\\pL0-9_]+~u', '-', $this->path);
        $slug = trim($slug, "-");
        $slug = iconv("utf-8", "us-ascii//TRANSLIT", $slug);
        $slug = strtolower($slug);
        $slug = preg_replace('~[^-a-z0-9_]+~', '', $slug);
        $this->path = $slug;
        return $this->path;
    }

    /**
     * Get the options for generating the slug.
     * https://www.larablocks.com/package/padosoft/laravel-sluggable
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('path');
    }





}
