<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
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
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:categories,name,$id",
            "slug" => "required|unique:categories,slug,$id",
        ]);
        if ($validator->passes()) {
            $category = Category::find($id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            if ($request->hasFile('image')){
                $category->image =  $this->uploadimage($request);
            }
            $category->save();
            return redirect()->route('category.index')->with('success','category updated successfully');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        };
    }
    public function delete ($id) {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category.index')->with('success','category deleted successfully');
    }

    private function uploadimage(Request $request){
        return $request->file('image')->store('images' ,'public');
    }
}
