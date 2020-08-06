<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Slug;
use App\Page;
use App\Template;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slug = Slug::where('homepage',true)->first();
        if(!empty($slug)) {
            $page = $slug->slugable;
            $template = Template::findOrFail($page->template);
            return view($template->filename,compact('page'));
        } else return "No homepage set";
    }

    /**
     * Dynamic url routing for pages without parent
     *
     * @return \Illuminate\Http\Response
     */
    public function routingSingle($slug)
    {
        $slugs = Slug::get();
        $page;
        foreach($slugs as $path) {
            if($path->path == $slug) $page = $path->slugable;
        }

        if(!empty($page)) {
            //check if page == homepage
            if($page->slug->homepage == true) return redirect('/', 301);

            $template = Template::findOrFail($page->template);
            if(view()->exists($template->filename)) return view($template->filename,compact('page'));
            else return "view does not exsist";
        } 
        return abort(404);
    }

    /*
    *  Dynamic url routing for pages with a parent
    */
    public function routingChild($parent,$child)
    {
        $slugs = Slug::get();
        foreach($slugs as $slug) {
            if($slug->path == $child) {
                //the child exsists in slug table
                //now we will validate if the parent exists
                if(!empty($slug->slugable->parent)) {
                    if($slug->slugable->parent->slug->path == $parent) {
                        //slug child and parent exsist in slug table
                        //we will lookup what template to load and return the view
                        $template = Template::findOrFail($slug->slugable->template);
                        $page = $slug->slugable;
                        if(view()->exists($template->filename)) return view($template->filename,compact('page'));
                        else return "view does not exsist";
                    }
                }
            }
        }
        return abort(404);            
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
        
    }

    
}
