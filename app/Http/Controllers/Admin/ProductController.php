<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Category;
use App\Models\product;
use App\Models\productImage;
use App\Models\subCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.products.list',compact('products'));
    }

    public function create()
    {
        $categorys = Category::orderBy('name', 'ASC')->get();
        $brands = Brands::orderBy('name','ASC')->get();
        $subCategorys = subCategory::orderBy('name','ASC')->get();
        return view('admin.pages.products.create',compact('categorys', 'brands','subCategorys'));
    }

    public function store(Request $request)
    {
        $rules = [
            "name" => "required",
            "slug" => "required|unique:products",
            "price" => "required|numeric",
            "sku" => "required",
            "track_qty" => "required|in:Yes,No",
            "category" => "required|numeric",
            "is_featured" => "required|in:Yes,No",
        ];
        if (!empty($request->track_qty) && $request->track_qty == "Yes") {
            $rules["qty"] = "required|numeric";
        }
        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()) {
            $product = new product();
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->track_qty = $request->track_qty;
            $product->category_id = $request->category;
            $product->is_featured = $request->is_featured;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->barcode = $request->barcode;
            $product->save();
            if ($request->hasFile('image')) {
                foreach ( $request->file('image') as $image ) {
                    $productImage = new productImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = $this->uploadimage($image);
                    $productImage->save();
                }
            };

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
    private function uploadimage($image){
        return $image->store('images' ,'public');
    }
}
