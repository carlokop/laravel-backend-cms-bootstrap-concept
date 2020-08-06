<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Post;
use App\Slug;
use Illuminate\Validation\Rule;
use Validator;

class AdminPostCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        return view('admin.posts.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category;
        return view('admin.posts.category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'path' => 'required|unique:slugs|max:255',
        ]);
        
        $cat = Category::create(['name' => $request->name]);
        $slug = new slug;
        $slug->path = $request->path;
        $slug->cleanup();
        $cat->slug()->save($slug);
        
        return redirect()->route('admin.posts.category');
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
        $category = Category::findOrFail($id);
        return view('admin.posts.category.edit', compact('category'));
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
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required','max:255',Rule::unique('categories')->ignore($category->id),],
        ]);
        
        if ($validator->fails()) {
            return redirect($request->path() . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $category->update($request->all());
        return redirect()->route('admin.posts.category');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $slug = $category->slug;

        //first remove this category from all posts that still use this category
        $posts = $category->posts()->get();
        foreach($posts as $post) {
            $post->categories()->detach([$id]);
        }
        
        //delete and return
        $category->delete();
        $slug->delete();
        return redirect()->route('admin.posts.category');
    }


    /* API methods */

    //returns all categories as json
    public function categoriesApi() {
        $categories = Category::get();
        return json_encode($categories);
    }

    //returns single categories as json
    //slug = false will return the category object
    //slug = true with return the slug
    public function categoryApi($id,$slug = true) {
        $category = Category::findOrFail($id);
        if($slug) return json_encode($category->slug);
        else return json_encode($category);
    }
}
