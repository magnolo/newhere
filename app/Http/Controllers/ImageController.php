<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use File;
use Validator;
use App\Image;
use App\Logic\Image\ImageRepository;

class ImageController extends Controller
{
    //


    public function test(Request $request){
      return response()->json($request->all());
    }
    public function uploadImage(ImageRepository $imageRepository, Request $request){
        $image = $request->file('file');
      //  $result = $this->upload($image);

        $result = $imageRepository->upload($image);

        $image = new Image();
        $image->basename = $result['basename'];
        $image->dir = $result['dir'];
        $image->filename = $result['filename'];
        $image->size = $result['original_filesize'];
        $image->width = $result['original_width'];
        $image->height = $result['original_height'];
        $image->save();

        return response()->json($image);

    }


}
