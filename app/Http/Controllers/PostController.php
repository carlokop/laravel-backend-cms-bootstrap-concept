<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Page;
use App\Category;
use App\Slug;
use App\Comment;

class PostController extends Controller
{

    public function __construct() {
        //$user = Auth::user();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::get();
        $page = new Page(['title' => 'All Posts']);
        return view('faq.index')
            ->with(compact('post',$post))
            ->with(compact('page',$page));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function routingSingle($uri)
    {
        if($slug = Slug::where('path',$uri)->first()) {
            if($slug->slugable_type == 'App\Category') {
                $category = Category::findOrFail($slug->slugable->id);
                return view('faq.category',compact('category'));
            } elseif($slug->slugable_type == 'App\Post') {
                $post = Post::findOrFail($slug->slugable->id);
                $category = null;
                $user = Auth::user();
                $comment = new Comment;
                return view('faq.single')
                    ->with(compact('post',$post))
                    ->with(compact('comment',$comment))
                    ->with(compact('user',$user))
                    ->with(compact('category',$category));
            } else return abort(404);
        } else return abort(404);
    }

    /**
     * Display a listing of the resource with parant
     *
     * @return \Illuminate\Http\Response
     */
    public function routingCategory($cat,$uri)
    {
        if($slug = Slug::where('path', $uri)->first()) {
            $post = Post::findOrFail($slug->slugable->id);
            $category = Category::findOrFail($post->category_id);
            if($category->slug->path == $cat) {
                $comment = new Comment;
                return view('faq.single')
                    ->with(compact('post',$post))
                    ->with(compact('comment',$comment))
                    ->with(compact('category',$category));
            } else return abort(404);
        } else return abort(404);
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
