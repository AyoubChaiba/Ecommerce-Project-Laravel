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
        return view('admin.pages.products.create',compact('categorys', 'brands'));
    }

    public function store(Request $request)
    {
        $rules = [
            "title" => "required",
            "slug" => "required|unique:products,slug",
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


        if ( empty($request->image_id)) {
            
        }

        if ($validator->passes()) {
            $product = new product();
            $product->title = $request->title;
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

            return response()->json([
                'status' => true,
                'message' => 'Product added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        };
    }
    public function edit(string $id)
    {
        $product = product::find($id);
        $categorys = Category::orderBy('name', 'ASC')->get();
        $brands = Brands::orderBy('name','ASC')->get();
        return view('admin.pages.products.edit', compact('product','categorys','brands'));
    }

    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return redirect()->route('products.index')->with('error','product not found');
        }
        $rules = [
            "title" => "required",
            "slug" => "required|unique:products,slug,".$product->id,
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
            $product->title = $request->title;
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
            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        };
    }

    public function destroy(string $id)
    {
        $products = product::find($id);
        $products->delete();
        return redirect()->route('products.index')->with('success','products deleted successfully');
    }

    public function productSubcategory (Request $request) {
        $productSubCategory = subCategory::where('category_id',$request->category_id)->orderBy('name','ASC')->get();
        return response()->json($productSubCategory);
    }
}
