<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $brands = product::orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.products.list',compact('brands'));
    }

    public function create()
    {
        return view('admin.pages.products.create');
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
            $category = new product();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            if ($request->hasFile('image')){
                $category->image =  $this->uploadimage($request);
            }
            $category->save();
            return redirect()->route('products.index')->with('success','product added successfully');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        };
    }
    public function edit(string $id)
    {
        $product = product::find($id);
        return view('admin.pages.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:products,name,$id",
            "slug" => "required|unique:products,slug,$id",
        ]);
        if ($validator->passes()) {
            $products = product::find($id);
            $products->name = $request->name;
            $products->slug = $request->slug;
            $products->status = $request->status;
            $products->save();
            return redirect()->route('products.index')->with('success','products updated successfully');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        };
    }

    public function destroy(string $id)
    {
        $products = product::find($id);
        $products->delete();
        return redirect()->route('products.index')->with('success','products deleted successfully');
    }
}
