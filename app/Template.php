<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'filename'
    ];

    //one to many
    public function pages()
    {
        return $this->hasMany('App\Page');
    }

}
