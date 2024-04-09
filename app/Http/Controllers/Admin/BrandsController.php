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
            "name" => "required",
            "slug" => "required|unique:brands,slug",
        ]);
        if ($validator->passes()) {
            $brands = new Brands();
            $brands->name = $request->name;
            $brands->slug = $request->slug;
            $brands->status = $request->status;
            $brands->save();
            return response()->json([
                'status' => true,
                'message' => 'brands added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        };
    }
    public function edit(string $id)
    {
        $brand = Brands::find($id);
        if (empty($brand)){
            return redirect()->route('brands.index')->with('error','brand not found.');
        }
        return view('admin.pages.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $brand = Brands::find($id);
        if (empty($brand)){
            return redirect()->route('brands.index')->with('error','brand not found.');
        }
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "slug" => "required|unique:categories,slug," . $brand->id,
        ]);
        if ($validator->passes()) {
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();
            return response()->json([
                'status' => true,
                'message' => 'brands updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brands = Brands::find($id);
        if (empty($brands)){
            return redirect()->route('sub-category.index')->with('error','brand not found.');
        }
        $brands->delete();
        return response()->json([
            'status' => true,
            'message' => 'Brand deleted successfully.',
        ]);
    }

}
