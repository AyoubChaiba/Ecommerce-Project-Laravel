<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class categoriesController extends Controller
{
    public function index() {
        $categories = Category::orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.categories.list', compact('categories'));
    }
    public function create() {
        return view('admin.pages.categories.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:categories,name",
            "slug" => "required|unique:categories,slug",
        ]);
        $validator->after(function ($validator) use ($request) {
            $slug = $request->slug;
            $generatedSlug = Str::slug($slug);
            if ($slug !== $generatedSlug) {
                $validator->errors()->add('slug', 'The slug format is invalid.');
            }
        });
        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();
            if (isset($request->image_id)) {
                $tempIamge = TempImages::find($request->image_id);
                // $name  = last(explode('.', $tempIamge->name));
                $sPath = public_path().'/temp/'.$tempIamge->name;
                $dPath = public_path().'/uploads/category/'.$request->image_id.'-'.$tempIamge->name;
                File::copy($sPath, $dPath);
                $category->image = $request->image_id.'-'.$tempIamge->name;
                $category->save();
            }

            Session::flash('success', 'The category was successfully added.');
            return response()->json([
                'status' => true,
                'message' => 'Category added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function edit ($id) {
        $category = Category::find($id);
        return view('admin.pages.categories.edit', compact('category'));
    }

    public function update (Request $request, $id) {
        $category = Category::find($id);
        if (empty($category)) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ]);
        }
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "slug" => "required|unique:categories,slug," . $category->id,
        ]);
        $validator->after(function ($validator) use ($request) {
            $slug = $request->slug;
            $generatedSlug = Str::slug($slug);
            if ($slug !== $generatedSlug) {
                $validator->errors()->add('slug', 'The slug format is invalid.');
            }
        });
        if ($validator->passes()) {
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();
            $oldImage = $category->image ;
            if (isset($request->image_id)) {
                $tempIamge = TempImages::find($request->image_id);
                $sPath = public_path().'/temp/'.$tempIamge->name;
                $dPath = public_path().'/uploads/category/'.$request->image_id.'-'.$tempIamge->name;
                File::copy($sPath, $dPath);
                $category->image = $request->image_id.'-'.$tempIamge->name;
                $category->save();
                File::delete(public_path().'/uploads/category/'.$oldImage);
            }
            Session::flash('success', 'The category was successfully update.');
            return response()->json([
                'status' => true,
                'message' => 'Category update successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        };
    }
    public function delete ($id) {
        $category = Category::find($id);
        if (empty($category)) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ]);
        }
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully.',
        ]);
    }

}
