<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brands::orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.brands.list',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:brands,name",
            "slug" => "required|unique:brands,slug",
        ]);
        if ($validator->passes()) {
            $category = new Brands();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            if ($request->hasFile('image')){
                $category->image =  $this->uploadimage($request);
            }
            $category->save();
            return redirect()->route('brands.index')->with('success','brands added successfully');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        };
    }
    public function edit(string $id)
    {
        $brand = Brands::find($id);
        return view('admin.pages.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:categories,name,$id",
            "slug" => "required|unique:categories,slug,$id",
        ]);
        if ($validator->passes()) {
            $brands = Brands::find($id);
            $brands->name = $request->name;
            $brands->slug = $request->slug;
            $brands->status = $request->status;
            $brands->save();
            return redirect()->route('brands.index')->with('success','brands updated successfully');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brands = Brands::find($id);
        $brands->delete();
        return redirect()->route('brands.index')->with('success','brands deleted successfully');
    }
}
