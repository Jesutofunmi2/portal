<?php

namespace App\Http\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageUploader{


    public static function saveImage(Request $request, $folder){

        $extension = $request->file('logo')->extension();
      
        $file_name = $folder.'/'.uniqid().'.'.$extension;

        $manager = new ImageManager(array('driver' => 'gd'));

        $image = $manager->make($_FILES['logo']['tmp_name']);
        
        // Resizing the images
        $image->resize(200,200)->encode(null,75);

        // Storing the images...
        $path = Storage::put($file_name, (string) $image );

        // Getting the URL....
        $url =  '/'.$file_name;
       
        return $url;
    }

    public static function saveSignatures(Request $request, $name, $folder){

        $extension = $request->file($name)->extension();
      
        $file_name = $folder.'/'.uniqid().'.'.$extension;

        $manager = new ImageManager(array('driver' => 'gd'));

        $image = $manager->make($_FILES[$name]['tmp_name']);
        
        // Resizing the images
        $image->resize(200,200)->encode(null,75);

        // Storing the images...
        $path = Storage::put($file_name, (string) $image );

        // Getting the URL....
        $url =  '/'.$file_name;
       
        return $url;
    }
}