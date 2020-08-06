<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use Validator;
//use App\Post;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validatedData = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validatedData->fails()) {
            return redirect(url()->previous() . "#errors")->withErrors($validatedData->errors())->withInput();
        }

        if($user = Auth::user()) {
            
            /* The form initialising this method requires two hidden fields
            *  $request->postType should hold the model name
            *  $request->post should hold the id in that model 
            */

            if($request->postType) {
                
                $class = 'App\\' . $request->postType; //abstract model, most likely Post
                $post = $class::findOrFail($request->post);
                
                $comment = new Comment;
                $comment->body = $request->comment;
                if($request->commentId) $comment->comment_parent_id = $request->commentId;
                $comment = $user->comments()->save($comment);

                //assign comment to post
                $post->comments()->attach($comment->id);

                //Create a admin notification for all admins
                $admins = $user->whereHas(
                    'role', function($q){
                        $q->where('name', 'admin');
                    }
                )->get();
                
                foreach($admins as $admin) {
                    $admin->notify(new \App\Notifications\CommentAdded($comment));
                }

                if($request->ajax) {
                    return json_encode($comment);
                } else {
                    $request->session()->flash('status', 'Comment will be published after validation');
                    return redirect(url()->previous() . "#commentForm");
                }


            }

        } 
        
    }

    /* We use this method for creating an new user and save the comment
    *  In this method we will only validate and let the UserController
    *  and the $this->store method handle saving to the DB
    */
    public function storeuser(Request $request)
    {

        //return $request;
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:255',
            'password2' => 'required|same:password',
            'comment' => 'required',
        ]);

        if ($validatedData->fails()) {
            return redirect(url()->previous() . "#errors")->withErrors($validatedData->errors())->withInput();
        }

        $usersController = new UsersController;
        $user = $usersController->store($request);

        Auth::login($user);
        return $this->store($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    
    





}
