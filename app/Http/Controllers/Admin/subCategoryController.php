<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\subCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class subCategoryController extends Controller

{

    public function index() {
        $subCategories = SubCategory::with('category')->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.pages.subcategory.list', compact('subCategories'));
    }
    public function create() {
        $categorys = Category::orderBy('name', 'ASC')->get();
        return view('admin.pages.subcategory.create',compact('categorys'));
    }
    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            "name" => "required|unique:sub_categories,name",
            "slug" => "required|unique:sub_categories,slug",
            "category_id" => "required",
        ]);

        $validator->after(function ($validator) use ($request) {
            $slug = $request->slug;
            $generatedSlug = Str::slug($slug);
            if ($slug !== $generatedSlug) {
                $validator->errors()->add('slug', 'The slug format is invalid.');
            }
        });

        if ($validator->passes()) {
            $category = new subCategory();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->category_id = $request->category_id;
            $category->save();
            Session::flash('success', 'The sub category was successfully added.');
            return response()->json([
                'status' => true,
                'message' => 'Sub Category added successfully',
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }
    public function edit($id) {
        $subCategory = SubCategory::find($id);
        if (empty($subCategory)){
            return redirect()->route('sub-category.index')->with('error','sub category not found.');
        }
        $categorys = Category::orderBy('name', 'ASC')->get();
        return view('admin.pages.subcategory.edit', compact('subCategory', 'categorys'));
    }

    public function update(Request $request, $id) {
        $subCategory = subCategory::find($id);

        if (empty($subCategory)){
            return redirect()->route('sub-category.index')->with('error','sub category not found.');
        }

        $validator = Validator::make($request->all(),[
            "name" => "required",
            "slug" => "required|unique:sub_categories,slug," . $subCategory->id,
        ]);

        $validator->after(function ($validator) use ($request) {
            $slug = $request->slug;
            $generatedSlug = Str::slug($slug);
            if ($slug !== $generatedSlug) {
                $validator->errors()->add('slug', 'The slug format is invalid.');
            }
        });

        if ($validator->passes()) {
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category_id;
            $subCategory->save();
            Session::flash('success', 'The sub category was successfully update.');
            return response()->json([
                'status' => true,
                'message' => 'sub category updated successfully',
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }
    public function delete($id) {
        $subCategory = SubCategory::find($id);
        if (empty($subCategory)){
            return redirect()->route('sub-category.index')->with('error','sub category not found.');
        }
        $subCategory->delete();
        return response()->json([
            'status' => true,
            'message' => 'Sub category deleted successfully',
        ]);
    }
}
