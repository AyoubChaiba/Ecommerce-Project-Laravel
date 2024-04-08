<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImages;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TempImagesController extends Controller
{
    public function index(Request $request) {
        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $imagename = time().'.'.$request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img = $img->resize(300, 200);
            $img->toJpeg(80)->save(public_path().'/temp/'.$imagename);
            $tempImage = new TempImages;
            $tempImage->name = $imagename;
            $tempImage->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Image saved successfully.',
                'image_id' => $tempImage->id,
            ]);
        }
    }

}
