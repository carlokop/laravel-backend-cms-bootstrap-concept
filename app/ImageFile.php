<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ImageFile extends Model
{
    //add or edit image formats here
    //order from larger to smaller
    protected $image_sizes = [
        'large'     =>  1200,
        'medium'    =>  768,
        'small'     =>  300
    ];

    protected $fillable = [
        'path',
        'size_type',
        'size',
        'file_type',
        'resolution'
    ];

    protected $units = [
        'B'  => 1,
        'KB' => 1024,
        'MB' => 1024576,
        'GB' => 1073741814,
        'PB' => 1099511627776
    ];

    public $upload_dir = "storage/images/";

    /**********************
    * Relationships 
    **********************/

    //one to many inverse
    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    //sanitizes the filename
    public function regex_filename($file) {
        $filename = strtolower($file);
        $filename = preg_replace("/ /i", '-', $filename);
        $filename = preg_replace("/[^a-z0-9\_\-\.()]/i", '', $filename);
        return $filename;
    }

    //if filename already excists add new version number to filename
    //at the moment this will only check for the first (1)
    public function filename_version($filename) {
        $filenameArray = explode('.', $filename);
        $extension = array_pop($filenameArray);
        $filename = "";
        foreach($filenameArray as $name) {
            $filename .= $name;
        }
        //check if filename has version and set new name
        if(preg_match("/\([0-9]+\)/",$filename,$out)) {
            $i = array_pop($out);
            preg_match('!\d+!', $i, $index);
            $version = array_pop($index);
            $new_version = $version + 1;
            $filename = str_replace('('.$version.')', '('.$new_version.')', $filename);
        } else {
            $filename .= "-(1)";
        }
        return $filename . '.' .$extension;
    }

    public function set_db_props_from_file($file,$filename) {
        $extension = $file->extension() == 'jpeg' ? 'jpg' : $file->extension();
        $this->file_type = $file->getMimeType();
        $this->path = $this->upload_dir . $filename;

        $resolution = [
            'width' => $this->get_resolution($file),
            'height' => $this->get_resolution($file,'height')
        ];
        $this->resolution = json_encode($resolution);
        $this->size_type = $this->get_size_type($resolution);
        $this->size = $file->getSize();
    }

    //returns file resolution with or height
    public function get_resolution($file,$dimension = 'width') {
        $data = getimagesize($file);
        $width = $data[0];
        $height = $data[1];
        return $dimension == 'height' ? $height : $width;
    }

    //returns image size as string e.g. full, large, medium, small
    public function get_size_type($resolution) {
        $width = $resolution['width'];
        $height = $resolution['height'];

        //get biggest width or height
        $size = $width > $height ? $width : $height;
        $image_size_description = "full";
        foreach($this->image_sizes as $image_size => $value) {
            if($size <= $value) $image_size_description = $image_size;
        }
        return $image_size_description;
    }

    //returns array of object with all the sizes and resolutions
    public function save_to_sizes() {
        $file = json_decode($this->resolution);

        $sizes = [
            'full'   => ['width' => $file->width, 'height' => $file->height]
        ];

        $landscape = $file->width >= $file->height ? true : false;

        foreach($this->image_sizes as $image_size => $value) {
            if($value < $file->width) {
                $sizes[$image_size] = ['width' => $this->ratio($landscape,'width', $file, $value), 'height' => $this->ratio($landscape,'height', $file, $value)];
            }
        }

        return $sizes;
    }

    //required by save_to_sizes to calculate resolutions for diffrent sizes by orientation
    private function ratio($landscape,$direction, $file, $resolution) {
        if($landscape) {
            return $direction == 'width' ? $resolution : round(($file->height / $file->width) * $resolution);
        } else {
            return $direction == 'width' ? round(($file->width / $file->height) * $resolution) : $resolution;
        }
    }

    /*
    * This method will resize an given image to an resolution with aspected ratio
    * We use Intervention for this but we where getting issues with the Laravel Storage facades
    * So now we are resizing it and moving it to a temp location from where we move it to permanent storage
    * We return the url in the storage folder to be used for DB info via storage facade in the controller
    */
    public function save_file_resize($file, $width, $height,$filename) {
        $manager = new ImageManager(array('driver' => 'imagick'));
        $image = Image::make($file);

        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        //save temp file
        $image->save(public_path('tmp/'.$filename));

        //move to storage
        $saved_image_uri = $image->dirname.'/'.$image->basename;
        Storage::putFileAs('public/images/', new File($saved_image_uri), $filename);

        //remove temp file
        $image->destroy();
        unlink($saved_image_uri);

        return Storage::url("public/images/{$filename}");
    }

    //returns filesize in Bytes, KB, MB, etc
    public function get_units($size = 0) {
        if($this->size) {
            $unit;
            $size = $size == 0 ? $this->size : $size;

            foreach($this->units as $key => $value) {
                if($size >= $value && $this->size != null) $unit = round(($size/$value)) . ' ' . $key;
            }
            return $unit;
        } 
    }

   




} //class
