<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Category;
use App\Models\product;
use App\Models\productImage;
use App\Models\subCategory;
use App\Models\TempImages;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::orderBy('created_at','DESC')->with('product_image')->paginate(10);
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
            "sku" => "required|unique:products,sku",
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

            if (isset($request->images_id)) {
                $manager = new ImageManager(new Driver());
                foreach ($request->images_id as $image_id) {
                    $temp_image = TempImages::find($image_id);
                    $product_image = new ProductImage;
                    $product_image->product_id = $product->id;
                    $product_image->image = $product->id . '-' . $temp_image->name;
                    $sPath = public_path() . '/temp/' . $temp_image->name;

                    // Process and save the small image
                    $img = $manager->read($sPath)->resize(300, 300)->toJpeg(95);
                    $img->save(public_path() . '/uploads/product/small/' . $product_image->image);

                    // Process and save the large image
                    $img = $manager->read($sPath)->scale(width: 1400)->toJpeg(95);
                    $img->save(public_path() . '/uploads/product/large/' . $product_image->image);

                    $product_image->save();
                }
            }

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
        $sub_categorys = subCategory::where('category_id', $product->category_id)->get();
        return view('admin.pages.products.edit', compact('product','categorys','brands','sub_categorys'));
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
            "sku" => "required|unique:products,sku,".$product->id,
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
            if (empty($request->sub_category)) {
                $product->sub_category_id = null;
            }
            $product->save();
            if (isset($request->images_id)) {
                $manager = new ImageManager(new Driver());
                $oldImages = ProductImage::where('product_id', $product->id)->get();

                foreach ($request->images_id as $image_id) {
                    $temp_image = TempImages::find($image_id);
                    if (!$temp_image) {
                        return "Error: Failed to upload image.";
                    }

                    $product_image = new ProductImage;
                    $product_image->product_id = $product->id;
                    $product_image->image = $product->id . '-' . $temp_image->name;
                    $sPath = public_path() . '/temp/' . $temp_image->name;

                    // Process and save the small image
                    $img = $manager->read($sPath)->resize(300, 300)->toJpeg(95);
                    $img->save(public_path() . '/uploads/product/small/' . $product_image->image);

                    // Process and save the large image
                    $img = $manager->read($sPath)->scale(width: 1400)->toJpeg(95);
                    $img->save(public_path() . '/uploads/product/large/' . $product_image->image);

                    $product_image->save();
                }

                foreach ($oldImages as $oldImage) {
                    File::delete([
                        public_path('/uploads/product/small/' . $oldImage->image),
                        public_path('/uploads/product/large/' . $oldImage->image)
                    ]);
                    $oldImage->delete();
                }
            }

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
        $product = product::find($id);
        $images_products = ProductImage::where('product_id', $product->id)->get();
        foreach ($images_products as $image_product) {
            File::delete([
                public_path('/uploads/product/small/' . $image_product->image),
                public_path('/uploads/product/large/' . $image_product->image)
            ]);
            $image_product->delete();
        }
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ]);
    }

    public function productSubcategory (Request $request) {
        $productSubCategory = subCategory::where('category_id',$request->category_id)->orderBy('name','ASC')->get();
        return response()->json($productSubCategory);
    }
}
