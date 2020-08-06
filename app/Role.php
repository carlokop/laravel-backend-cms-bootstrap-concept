<?php

/*
 * This model sets user roles
 * The users model is related to this model
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];

    //one to many
    public function users()
    {
        return $this->hasMany('App\User');
    }

    
}
