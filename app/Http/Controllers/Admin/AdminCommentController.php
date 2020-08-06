<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use App\Category;

class AdminCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //remove reaction to comments when parent is trashed
        $trashedComments = Comment::onlyTrashed()->get();
        $trashedIds = array();
        foreach($trashedComments as $trashedComment) {
            array_push($trashedIds, $trashedComment->id);
        }

        $comments = Comment::whereNull('comment_parent_id')
        ->orWhereNotIn('comment_parent_id', $trashedIds)
        ->get();

        return view('admin.comments.index')
            ->with(compact('comments',$comments));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comments.edit')
            ->with(compact('comment',$comment));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->approved = $request->approved == 'on' ? true : false;

        $comment->body = $request->body;
        $comment->save();

        return redirect()->route('admin.comments');
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->approved = true;
        $comment->save();
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back();
    }

    //show trashed posts
    public function trash() {
        $comments = Comment::onlyTrashed()->get(); 
        $categories = Category::get();
        return view("admin.comments.trash")
            ->with(compact('categories',$categories))
            ->with(compact('comments',$comments));
    }

    //empty trashed post single item
    public function destroytrashed($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->posts()->sync([]);
        $comment->forceDelete();

        //delete answers to comment as well
        $comments = Comment::where('comment_parent_id',$id)->get();
        foreach($comments as $comment) {
            $comment->forceDelete();
        }
        return redirect()->back();
    }

    //empty all trashed posts at once
    public function emptytrash() {
        $comments = Comment::onlyTrashed()->get(); 
        foreach($comments as $comment) {
            $comment->posts()->sync([]);
            $comment->forceDelete();
        }
        return redirect()->back();
    }

    //restore trashed post single item
    public function restoretrashed($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();
        return redirect()->back();
    }

    //restore all trashed posts
    public function restoretrash() {
        $comments = Comment::onlyTrashed()->get(); 
        foreach($comments as $comment) {
            $comment->restore();
        }
        return redirect()->route('admin.comments');
    }

    /* API Methods */

    public function commentApi($id) {
        $comment = Comment::findOrFail($id);
        $comment->user;
        $comment->posts;
        return json_encode($comment);
    }






}
