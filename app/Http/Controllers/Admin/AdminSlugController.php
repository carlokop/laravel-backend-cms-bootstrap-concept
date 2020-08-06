<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Slug;

class AdminSlugController extends Controller
{
    
    //API request all slugs
    public function slugs() {
        $slugs = Slug::get();
        return json_encode($slugs);
    }

    //sanetises slug->path and return as API request
    public function sanatise($path) {
        $slug = new Slug;
        $slug->path = $path;
        $slug->cleanup();
        return json_encode($slug);
    }


}
