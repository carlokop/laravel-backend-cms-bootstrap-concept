<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ImageFile;
use App\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AdminMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();
        return view('admin.media.index', compact('images'));
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
        $request->validate([
            'file' => 'required|mimes:jpeg,jpg,png,gif',
        ]);

        /* 
        * After validation we will create multiple versions of this file
        * we will save the image->name in the Image model
        * multiple files based on resolution will be saved in ImageFile model
        * first we will set the full version of the file
        * the intervention plugin does resizing but prevents us from using the same methods
        */

        if($file = $request->file('file')) {

            //set imageFile object full version
            $imageFile = new ImageFile();

            //sanatise filename
            $filename = $imageFile->regex_filename($file->getClientOriginalName());
            $filenameNoExtension = pathinfo($filename, PATHINFO_FILENAME); //image->name
            $extension = \File::extension($filename);

            //check if filename already excists on storage and save
            if(Storage::exists('public/images/'. $filename)) {
                //image already excists on filesystem we need to rename
                do {
                    $filename = $imageFile->filename_version($filename);
                }
                while(Storage::exists('public/images/'. $filename));
            } 
            Storage::putFileAs('public/images', new File($file), $filename);
            //return Storage::url($filename);

            //create DB image object
            $image = Image::create(['name' => $filenameNoExtension]);

            //set DB object imageFile for full version
            $imageFile->set_db_props_from_file($file,$filename);
            $sizes = $imageFile->save_to_sizes();
            $image->imagefiles()->save($imageFile);

            //we like to save the files in diffrent resolution to the filesystem
            foreach($sizes as $sizeKey => $sizeValue) {
                $img = new ImageFile();

                //save images
                if($sizeKey != 'full') {
                    //set images in diffrent sizes to filesystem
                    $filenameUpdated = pathinfo($filename, PATHINFO_FILENAME); 
                    $img->path = $filenameUpdated . "-" . $sizeValue['width'] . "-" . $sizeValue['height'] . "." . $extension;
                    $resizedImageFile = $imageFile->save_file_resize($file, $sizeValue['width'], $sizeValue['height'], $img->path);

                    $img->path = 'storage/images/' . $img->path;
                    
                    $img->file_type = Storage::mimeType(str_replace('/storage/','public/',$resizedImageFile));
                    $img->size = Storage::size(str_replace('/storage/','public/',$resizedImageFile));                   

                    $resolution = [
                        'width' => $sizeValue['width'],
                        'height' => $sizeValue['height']
                    ];
                    $img->resolution = json_encode($resolution);
                    $img->size_type = $img->get_size_type($resolution);

                    $image->imagefiles()->save($img);
                }

                //Add upload to log
                $date = new \DateTime();
                $user = \Illuminate\Support\Facades\Auth::user();
                Storage::append('logs/images.log', $filename . ' uploaded to filesystem on ' . $date->format('Y-m-d H:i:s') . ' by ' . $user->name);
                
            }

        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::findOrFail($id);
        return view('admin.media.edit', compact('image'));
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
        $request->validate([
            'imageName' => 'max:255',
            'imageAlt' => 'max:255',
            'imageTitle' => 'max:255',
        ]);

        $image = Image::findOrFail($id);
        $image->name = $request->imageName;
        $image->alt = $request->imageAlt;
        $image->title = $request->imageTitle;

        $image->save();

        return redirect()->route('admin.media.update',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $imageFiles = $image->imageFiles;

        foreach($imageFiles as $imageFile) {
            //remove files from filesystem
            $file = ImageFile::findOrFail($imageFile->id);
            Storage::delete(str_replace('storage/','public/',$imageFile->path));

            //remove object
            $imageFile->delete();
        }
        $image->delete();

        return redirect()->route('admin.media');

    }


    /* API methods */

    //returns all images and image files
    public function allImagesApi() {
        $images = Image::get();
        foreach($images as $image) {
            $image->imagefiles;
            foreach($image->imagefiles as $img) {
                $img->resolution = json_decode($img->resolution);
            }

        }
        return json_encode($images);    
    }

    //returns last uploaded image
    public function mediaupload() {
        $image = Image::latest()->first();
        $imageFile = $image->imageFiles->first();
        $resolution = json_decode($imageFile->resolution);

        return response()->json([
            'name' => $image->name,
            'alt' => $image->alt,
            'path' => asset($imageFile->path),
            'link' => asset('admin/media/'.$image->id),
            'width' => $resolution->width,
            'height' => $resolution->height,
        ]);
    }

    public function imageApi($id) {
        $image = Image::findOrFail($id);
        $image->imageFiles;
        return json_encode($image);
    }







}
