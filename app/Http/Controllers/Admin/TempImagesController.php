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
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $tempImage = new TempImages;
            $tempImage->name = $image_name;
            $tempImage->save();
            $image->move(public_path().'/temp/',$image_name);

            // $manager = new ImageManager(new Driver());
            // $img = $manager->read($request->file('image'));
            // $img = $img->resize(300, 200);
            // $img->toJpeg(80)->save(public_path().'/temp/'.$imagename);

            return response()->json([
                'status' => 'success',
                'message' => 'Image saved and resized successfully.',
                'image_id' => $tempImage->id,
            ]);
        }
    }

}
