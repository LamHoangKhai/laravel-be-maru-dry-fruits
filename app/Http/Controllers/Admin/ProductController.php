<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Weight;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\WeighTag;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    //view product
    public function index()
    {
        $product = Product::all();
        return view('admin.modules.product.index', [
            'product' => $product
        ]);
    }
    //view create product
    public function create()
    {
        $categories = Category::get();
        $weights = WeighTag::get();
        return view('admin.modules.product.create', ["categories" => $categories, "weights" => $weights]);
    }

    //create product
    public function store(StoreRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->nutrition_detail = $request->nutrition_detail;
        $product->status = $request->status;
        $product->category_id = $request->category_id;
        $product->feature = $request->feature;
        $product->created_at = date("Y-m-d h:i:s");
        $product->updated_at = date("Y-m-d h:i:s");

        //save  image
        $filename = rand(1, 10000) . time() . "." . $request->image->getClientOriginalName();
        // dd($request->image);
        $request->image->move(public_path("uploads"), $filename);
        $product->image = route("uploads") . "/" . $filename;
        
        // save qr code
        $lastestID = Product::latest()->first();
        $qrCodeImage = QrCode::size(100)->generate(route('admin.product.details', ['id' => $lastestID->id + 1]));
        $qrFilename = rand(1, 10000) . time() . "." . $lastestID->id + 1 . '.svg';
        file_put_contents(public_path("qrcode/{$qrFilename}"), $qrCodeImage);
        $product->qrcode = route("qrcode") . "/" . $qrFilename;

        $product->save();
        //insert in table Product_Weight
        $insert = [];
        foreach ($request->weights as $weight) {
            $insert[] = ["product_id" => $product->id, "weight_tag_id" => $weight];
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
        $product->description = $request->description;
        $product->nutrition_detail = $request->nutrition_detail;
        $product->status = $request->status;
        $product->feature = $request->feature;
        $product->category_id = $request->category_id;
        $product->updated_at = date("Y-m-d h:i:s");

        // save image
        if (isset($request->image)) {
            $file = public_path("uploads/") . $product->image;

            if (file_exists($file)) {
                unlink($file);
            }

            $filename = rand(1, 10000) . time() . "." . $request->image->getClientOriginalName();
            $request->image->move(public_path("uploads"), $filename);
            $product->image = route("uploads") . "/" . $filename;
        }

        //insert in table Product_Weight
        $insert = [];
        foreach ($request->weights as $weight) {
            $checkExist = Product_Weight::where([["product_id", $product->id], ["weight_tag_id", $weight]])->first();
            if (!$checkExist) {
                $insert[] = ["product_id" => $product->id, "weight_tag_id" => $weight];
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
        $product->delete();
        return redirect()->route('admin.product.index')->with("success", "Delete product success!");
    }


    // API get , search , filter 
    public function getProducts(Request $request)
    {
        $query = new Product();

        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;

        // search email, phone ,name 
        $query = $query->where("name", "like", "%" . $search . "%");

        //return data
        $result = $query->with("category")->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }

    // check total quantity product
    public function checkQuantity(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $totalQuantity = $product->stock_quantity + $product->store_quantity;
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "totalQuantity" => $totalQuantity]);
    }

    //remove weight tag
    public function removeWeightTag(Request $request)
    {
        $product_weight = Product_Weight::where([["product_id", $request->product_id], ["weight_tag_id", $request->weightTagId]])->first();
        if (!$product_weight) {
            return response()->json(['status_code' => 200, '404' => "Errors"]);
        }
        $product_weight->delete();
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn."]);
    }

    public function details($id) {
        $product_details = Product::where('id', $id)->get();
        return view('admin.modules.product.details', [
            'product' => $product_details
        ]);

    }






}
