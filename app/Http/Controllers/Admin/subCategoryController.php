<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\subCategory;
use Illuminate\Http\Request;
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
            "category" => "required",
            "status" => "required",
        ]);
        if ($validator->passes()) {
            $category = new subCategory();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->category_id = $request->category;
            $category->save();
            return redirect()->route('sub-category.index')->with('success','sub category added successfully');
        }
        return redirect()->route('sub-category.create')->withErrors($validator)->withInput();
    }
    public function edit($id) {
        $subCategory = SubCategory::find($id);
        $categorys = Category::orderBy('name', 'ASC')->get();
        return view('admin.pages.subcategory.edit', compact('subCategory', 'categorys'));
    }
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:sub_categories,name,$id",
            "slug" => "required|unique:sub_categories,slug,$id",
        ]);
        if ($validator->passes()) {
            $category = SubCategory::find($id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->category_id = $request->category;
            $category->save();
            return redirect()->route('sub-category.index')->with('success','sub category updated successfully');
        }
        return redirect()->route('sub-category.edit', $id)->withErrors($validator)->withInput();
    }
    public function delete($id) {
        $subCategory = SubCategory::find($id);
        $subCategory->delete();
        return redirect()->route('sub-category.index')->with('success','sub category deleted successfully');
    }
}
