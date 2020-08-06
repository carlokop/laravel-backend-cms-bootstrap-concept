<?php

/**
 * This model handels all comments
 * Comments are setup as Polymorphic so they can be added to other models than just the post model
 * Comments require a user. A one to many relation is setup for this
 * 
 * Since comments are handled on the front-end no crud is setup yet
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Comment extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['body','comment_parent_id'];

    /****************************************
     * Relations
     * **************************************/

    // One to many
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Polymorphic many to many relation
    public function posts()
    {
        return $this->morphedByMany('App\Post', 'commentable');
    }


    //get comment user gravatar
    public function get_gravatar($userId) {
        $user = User::findOrFail($userId);
        return $user->get_gravatar($user->email, $s = 70, $d = 'mp', $r = 'g');
    }



    



}
