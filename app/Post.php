<?php

/**
 * This model handels the blog Faq section
 * There are several polymorphic relations to this model for categories, ratings and comments
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Comment;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ['title','content'];

    /****************************************
     * Relations
     ***************************************/

    //one to many
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //primary category
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    // polymorphic one to one relation
    public function slug()
    {
        return $this->morphOne('App\Slug', 'slugable');
    }

    // polymorphic many to many relation
    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function comments()
    {
        return $this->morphToMany('App\Comment', 'commentable');
    }

    public function categories()
    {
        return $this->morphToMany('App\Category', 'categoryable');
    }


    /*
    *   Returns the comment count
    *   We can create reactions to comments. But is we delete of unapprove the parent comment the count is incorrect
    *   This method checks if the parent is approved and published and removes reactions to disabled comments from the comment count
    */
    public function approvedCommentCount() {
        $trashedComments = Comment::onlyTrashed()->get();
        $trashedIds = array();
        foreach($trashedComments as $trashedComment) {
            array_push($trashedIds, $trashedComment->id);
        }
        $unapprovedComments = Comment::where('approved', 0)->get();
        $unaprovedIds = array();
        foreach($unapprovedComments as $unapprovedComment) {
            array_push($unaprovedIds, $unapprovedComment->id);
        }
    
        $comments = Comment::whereNull('comment_parent_id')
            ->where('approved', 1)
            ->orWhereNotIn('comment_parent_id', $trashedIds)
            ->where('approved', 1)
            ->whereNotIn('comment_parent_id', $unaprovedIds)
            ->get();

        return $comments->count();
    }
 

    



}