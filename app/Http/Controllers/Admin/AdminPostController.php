<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Slug;
use App\Category;
use App\Image;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::get();
        $categories = Category::get();
        return view("admin.posts.index")
            ->with(compact('posts',$posts))
            ->with(compact('categories',$categories));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post;
        $auth = Auth::user();
        $users = User::get();
        $categories = Category::get();
        $image = null;
        $imagefiles = null;
        foreach($users as $user) {
            if($auth->id == $user->id) {
                $user->loggedin = true;
                break;
            }
        }
        return view('admin.posts.create')
            ->with(compact('post',$post))
            ->with(compact('users',$users))
            ->with(compact('categories',$categories))
            ->with(compact('image',$image))
            ->with(compact('imagefiles',$imagefiles));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        //return $request;
        $validatedData = $request->validate([
            'path' => 'required',
            'title' => 'required|max:255',
            'seo_title' => 'max:255',
            'og_image' => 'regex:'.$regex.'|nullable',
            'cannonical' => 'regex:'.$regex.'|nullable',
        ]);

        //save the post 
        $user = User::findOrFail($request->author);

        $post = new Post;
        $post->title = $request->title;
        $post->intro = $request->intro;
        $post->content = $request->content;
        $post->seo_title = $request->seo_title;
        $post->seo_description = $request->seo_description;
        $post->og_image = $request->og_image;
        $post->cannonical = $request->cannonical;
        $post->robots = $request->robots;
        $post->published = $request->published == 'on' ? true : false;

        if($request->primaryCategory != null) {
            $post->category_id = $request->primaryCategory;
        } else {
            $post->category_id = null;
        }

        $user->posts()->save($post);

        //create a slug and relate to the post
        $slug = new Slug;
        $slug->path = $request->path;
        $slug->cleanup();
        
        $post->slug()->save($slug);

        //assign categories to post
        $post->categories()->sync($request->categories);

        //set featured image
        $post->images()->sync($request->featured);

        return redirect()->route('admin.posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return "show " . $post->title;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $auth = Auth::user();
        $users = User::get();
        $categories = Category::get();
        $image = $post->images->first();
        return view('admin.posts.edit')
            ->with(compact('post',$post))
            ->with(compact('users',$users))
            ->with(compact('categories',$categories))
            ->with(compact('image',$image));
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
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        //return $request;
        $validatedData = $request->validate([
            'path' => 'required',
            'title' => 'required|max:255',
            'seo_title' => 'max:255',
            'og_image' => 'regex:'.$regex.'|nullable',
            'cannonical' => 'regex:'.$regex.'|nullable',
        ]);

        //save the post 
        $user = User::findOrFail($request->author);
        $post = Post::findOrFail($id);

        $post->title = $request->title;
        $post->intro = $request->intro;
        $post->content = $request->content;
        $post->seo_title = $request->seo_title;
        $post->seo_description = $request->seo_description;
        $post->og_image = $request->og_image;
        $post->cannonical = $request->cannonical;
        $post->robots = $request->robots;
        $post->published = $request->published == 'on' ? true : false;

        if($request->primaryCategory != null) {
            $post->category_id = $request->primaryCategory;
        } else {
            $post->category_id = null;
        }

        $user->posts()->save($post);

        //create a slug and relate to the post
        $slug = Slug::findOrFail($post->slug->id);
        $slug->path = $request->path;
        $slug->cleanup();
        
        $post->slug()->save($slug);

        //assign categories to post
        $post->categories()->sync($request->categories);

        //set featured image
        $post->images()->sync($request->featured);

        return redirect()->route('admin.posts');
    }

    /**
     * Remove the specified resource from storage.
     * Softdelete is active this method will not permanently delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id); 
        $post->delete();
        return redirect()->route('admin.posts');
    }

    //show trashed posts
    public function trash() {
        $posts = Post::onlyTrashed()->get(); 
        $categories = Category::get();
        return view("admin.posts.trash")
            ->with(compact('posts',$posts))
            ->with(compact('categories',$categories));
    }

    //empty trashed post single item
    public function destroytrashed($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->categories()->sync([]);
        $post->slug->delete();
        $post->forceDelete();
        return redirect()->route('admin.posts.trash');
    }

    //empty all trashed posts at once
    public function emptytrash() {
        $posts = Post::onlyTrashed()->get(); 
        foreach($posts as $post) {
            $post->categories()->sync([]);
            $post->slug->delete();
            $post->forceDelete();
        }
        return redirect()->route('admin.posts.trash');
    }

    //restore trashed post single item
    public function restoretrashed($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('admin.posts.trash');
    }

    //restore all trashed posts
    public function restoretrash() {
        $posts = Post::onlyTrashed()->get(); 
        foreach($posts as $post) {
            $post->restore();
        }
        return redirect()->route('admin.posts');
    }


    



} //class
