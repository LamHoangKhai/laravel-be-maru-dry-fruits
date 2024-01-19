<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Product_Weight;
use App\Models\Warehouse;
use App\Models\WeighTag;
use Carbon\Carbon;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    //view product
    public function index()
    {
        $product = Product::all();
        $categories = Category::all();
        return view('admin.modules.product.index', [
            'product' => $product,
            'categories' => $categories
        ]);
    }


    //view create product
    public function create()
    {
        $categories = Category::get();
        $weights = WeighTag::orderBy("mass", "ASC")->get();
        return view('admin.modules.product.create', ["categories" => $categories, "weights" => $weights]);
    }

    //create product
    public function store(StoreRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->sumary = $request->sumary;
        $product->description = $request->description;
        $product->nutrition_detail = $request->nutrition_detail;
        $product->status = $request->status;
        $product->category_id = $request->category_id;
        $product->feature = $request->feature;
        $product->created_at = Carbon::now();
        $product->updated_at = Carbon::now();

        //save  image

        // $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
        //     "folder" => 'dry_fruits_image',
        // ])->getSecurePath();

        $uploadedFileUrl =  UploadImageToCould($request->file('image')->getRealPath(), 'dry_fruits_image');

        $product->image = $uploadedFileUrl;
        $product->save();


        //insert in table Product_Weight
        $insert = [];
        foreach ($request->weights as $weight) {
            //save qr code
            $qrCodeImage = QrCode::size(100)->generate($product->id . $weight);
            $qrCodeData = 'data:image/svg+xml;base64,' . base64_encode($qrCodeImage);
            $uploadedQRUrl = UploadImageToCould($qrCodeData, 'dry_fruits_qrcode');
            $insert[] = ["id" => $product->id . $weight, "product_id" => $product->id, "weight_tag_id" => $weight, "qrcode" => $uploadedQRUrl];
        }
        Product_Weight::insert($insert);

        return redirect()->route('admin.product.index')->with("success", "Create product success!");
    }
    //view edit product
    public function edit(string $id)
    {
        $data = Product::with("weightTags")->findOrFail($id);
        $categories = Category::get();
        $weights = WeighTag::get();

        return view("admin.modules.product.edit", ["data" => $data, "id" => $id, "categories" => $categories, "weights" => $weights]);
    }
    // update product
    public function update(UpdateRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->sumary = $request->sumary;
        $product->description = $request->description;
        $product->nutrition_detail = $request->nutrition_detail;
        $product->status = $request->status;
        $product->feature = $request->feature;
        $product->category_id = $request->category_id;
        $product->updated_at = Carbon::now();

        // save image
        if (isset($request->image)) {
            $image = explode('/', $product->image);
            $old_image = explode('.', $image[sizeof($image) - 1]);

            try {
                // delete old image 
                DeleteImageOnCloud("dry_fruits_image/", $old_image[0]);
                // upload new image
                $uploadedFileUrl = UploadImageToCould($request->file('image')->getRealPath(), 'dry_fruits_image');
                $product->image = $uploadedFileUrl;
            } catch (\Exception $e) {
                echo "Error </br>";
                echo $e->getMessage();
                echo "</br>";
            }
        }

        //insert in table Product_Weight
        $insert = [];
        foreach ($request->weights as $weight) {
            $checkExist = Product_Weight::where([["product_id", $product->id], ["weight_tag_id", $weight]])->first();
            if (!$checkExist) {
                // save qr to clound
                $qrCodeImage = QrCode::size(100)->generate($product->id . $weight);
                $qrCodeData = 'data:image/svg+xml;base64,' . base64_encode($qrCodeImage);
                $uploadedQRUrl = UploadImageToCould($qrCodeData, 'dry_fruits_qrcode');
                $insert[] = ["id" => $product->id . $weight, "product_id" => $product->id, "weight_tag_id" => $weight, "qrcode" => $uploadedQRUrl];
            }
        }
        Product_Weight::insert($insert);

        $product->save();
        return redirect()->route('admin.product.index')->with("success", "Edit product success!");
    }
    //delete product
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $weightTags = Product_Weight::where("product_id", $product->id)->get();
        // delete weight tags
        foreach ($weightTags as $tag) {
            $image = explode('/', $tag->qrcode);
            $old_image = explode('.', $image[sizeof($image) - 1]);
            try {
                //  delete qrcode
                DeleteImageOnCloud("dry_fruits_qrcode/", $old_image[0]);
            } catch (\Exception $e) {
                echo "Error </br>";
                echo $e->getMessage();
                echo "</br>";
            }
            $tag->delete();
        }
        $product->delete();
        return redirect()->route('admin.product.index')->with("success", "Delete product success!");
    }


    // API get , search , filter 
    public function getProducts(Request $request)
    {
        $query = new Product();

        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;
        $select = $request->select;

        if ($select > 0) {
            $query = $query->where("category_id", "=", $select);
        }
        // search name 
        $query = $query->where("name", "like", "%" . $search . "%");

        //return data
        $result = $query->with(["category", "product_weight"])->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $result]);
    }

    //api scan qr
    public function detail(Request $request)
    {
        $data = Product_Weight::findOrFail($request->id);
        $product = Product::with(["category"])->findOrFail($data->product_id);
        $warehouse = Warehouse::select(["expiration_date", "input_price"])->where([["product_id", $product->id], ["transaction_type", 2]])->orderBy("created_at", "DESC")
            ->first();
        $qrWeightTags =  Product_Weight::with("weight_tag")->where("product_id", $product->id,)->get();
        $result = ["product" => $product, "warehouse" => $warehouse, "qr_weight_tag" => $qrWeightTags];
        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $result]);
    }


    // check total quantity product
    public function checkDelete(Request $request)
    {
        $product_id = $request->product_id;
        
        $query  = Order::with("order_items")->where("status", "<=", 3);
        $isNotComplete = $query
            ->whereHas("order_items", function ($query) use ($product_id) {
                $query->where("product_id", $product_id);
            })->first();


        if (!is_null($isNotComplete)) {
            return response()->json(['status_code' => 200, 'msg' => "This product has order not complete, cannot delete!!!.", "permission" => false]);
        };


        $product = Product::findOrFail($request->product_id);
        $totalQuantity = $product->stock_quantity + $product->store_quantity;
        return response()->json(['status_code' => 200, 'msg' => "Success", "totalQuantity" => $totalQuantity, "permission" => true]);
    }

    //remove weight tag
    public function removeWeightTag(Request $request)
    {
        $product_weight = Product_Weight::where([["product_id", $request->product_id], ["weight_tag_id", $request->weightTagId]])->first();
        if (!$product_weight) {
            return response()->json(['status_code' => 200, '404' => "Errors"]);
        }
        $image = explode('/', $product_weight->qrcode);
        $old_image = explode('.', $image[sizeof($image) - 1]);
        try {
            DeleteImageOnCloud("dry_fruits_qrcode/", $old_image[0]);
        } catch (\Exception $e) {
            echo "Error </br>";
            echo $e->getMessage();
            echo "</br>";
        }

        $product_weight->delete();
        return response()->json(['status_code' => 200, 'msg' => "Success"]);
    }
}
