<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Page;
use App\User;
use App\Slug;
use App\Image;
use App\Template;

class AdminPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::get();
        return view("admin.pages.index")
            ->with(compact('pages',$pages));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = new Page;
        $pages = Page::where('id', '!=', $page->id)->get();
        $auth = Auth::user();
        $users = User::get();
        $templates = Template::get();
        $image = null;
        $imagefiles = null;
        foreach($users as $user) {
            if($auth->id == $user->id) {
                $user->loggedin = true;
                break;
            }
        }
        return view('admin.pages.create')
            ->with(compact('page',$page))
            ->with(compact('pages',$pages))
            ->with(compact('users',$users))
            ->with(compact('image',$image))
            ->with(compact('imagefiles',$imagefiles))
            ->with(compact('templates',$templates));
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

        $validatedData = $request->validate([
            'path' => 'required',
            'title' => 'required|max:255',
            'seo_title' => 'max:255',
            'og_image' => 'regex:'.$regex.'|nullable',
            'cannonical' => 'regex:'.$regex.'|nullable',
        ]);

        //save the post 
        $user = User::findOrFail($request->author);

        $page = new Page;
        $page->title = $request->title;
        $page->intro = $request->intro;
        $page->content = $request->content;
        $page->seo_title = $request->seo_title;
        $page->seo_description = $request->seo_description;
        $page->og_image = $request->og_image;
        $page->cannonical = $request->cannonical;
        $page->robots = $request->robots;
        $page->template = $request->template;
        $page->parent_id = $request->hoofd == 0 ? null : $request->hoofd;
        $page->published = $request->published == 'on' ? true : false;

        $user->pages()->save($page);

        //create a slug and relate to the post
        $slug = new Slug;
        $slug->path = $request->path;
        $slug->cleanup();
        
        $page->slug()->save($slug);

        //set featured image
        $page->images()->sync($request->featured);

        return redirect()->route('admin.pages');
        
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
        $page = Page::findOrFail($id);
        $pages = Page::where('id', '!=', $page->id)->get();
        $auth = Auth::user();
        $users = User::get();
        $image = $page->images->first();
        $templates = Template::get();
        return view('admin.pages.edit')
            ->with(compact('page',$page))
            ->with(compact('pages',$pages))
            ->with(compact('users',$users))
            ->with(compact('image',$image))
            ->with(compact('templates',$templates));
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

        $validatedData = $request->validate([
            'path' => 'required',
            'title' => 'required|max:255',
            'seo_title' => 'max:255',
            'og_image' => 'regex:'.$regex.'|nullable',
            'cannonical' => 'regex:'.$regex.'|nullable',
        ]);

        //save the post 
        $user = User::findOrFail($request->author);
        $page = Page::findOrFail($id);

        $page->title = $request->title;
        $page->intro = $request->intro;
        $page->content = $request->content;
        $page->seo_title = $request->seo_title;
        $page->seo_description = $request->seo_description;
        $page->og_image = $request->og_image;
        $page->cannonical = $request->cannonical;
        $page->robots = $request->robots;
        $page->template = $request->template;
        $page->parent_id = $request->hoofd == 0 ? null : $request->hoofd;
        $page->published = $request->published == 'on' ? true : false;

        $user->pages()->save($page);

        //create a slug and relate to the post
        $slug = Slug::findOrFail($page->slug->id);
        $slug->path = $request->path;
        $slug->cleanup();
        
        $page->slug()->save($slug);

        //set featured image
        $page->images()->sync($request->featured);

        return redirect()->route('admin.pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id); 
        $page->delete();
        return redirect()->route('admin.pages');
    }

    //show trashed posts
    public function trash() {
        $pages = Page::onlyTrashed()->get(); 
        return view("admin.pages.trash")
            ->with(compact('pages',$pages));
    }

    //empty trashed post single item
    public function destroytrashed($id)
    {
        $page = Page::onlyTrashed()->findOrFail($id);
        $page->categories()->sync([]);
        $page->slug->delete();
        $page->forceDelete();
        return redirect()->route('admin.pages.trash');
    }

    //empty all trashed posts at once
    public function emptytrash() {
        $pages = Page::onlyTrashed()->get(); 
        foreach($pages as $page) {
            $page->slug->delete();
            $page->forceDelete();
        }
        return redirect()->route('admin.pages.trash');
    }

    //restore trashed post single item
    public function restoretrashed($id)
    {
        $page = Page::onlyTrashed()->findOrFail($id);
        $page->restore();
        return redirect()->route('admin.pages.trash');
    }

    //restore all trashed posts
    public function restoretrash() {
        $pages = Page::onlyTrashed()->get(); 
        foreach($pages as $page) {
            $page->restore();
        }
        return redirect()->route('admin.pages');
    }






}
