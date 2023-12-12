<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with("category")->get();
        $categories = Category::get();
        return view('admin.modules.product.index', ["products" => $data, "categories" => $categories]);
    }

    public function getProducts()
    {
        $data = Product::with("category")->orderBy("created_at", "DESC")->paginate(20);

        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $data]);
    }

    public function store(StoreRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->nutrition_detail = $request->nutrition_detail;
        $product->status = $request->status;
        $product->category_id = $request->category_id;
        $product->created_at = date("Y-m-d h:i:s");
        $product->updated_at = date("Y-m-d h:i:s");

        //save  image
        $filename = rand(1, 10000) . time() . "." . $request->image->getClientOriginalName();
        $request->image->move(public_path("uploads"), $filename);
        $product->image = $filename;

        $product->save();
        return redirect()->route('admin.product.index')->with("success", "Create product success!");
    }

    public function edit(string $id)
    {
        $data = Product::findOrFail($id);
        $categories = Category::get();
        return view("admin.modules.product.edit", ["data" => $data, "id" => $id, "categories" => $categories]);
    }
    public function update(UpdateRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->nutrition_detail = $request->nutrition_detail;
        $product->status = $request->status;
        $product->category_id = $request->category_id;
        $product->updated_at = date("Y-m-d h:i:s");

        if (isset($request->image)) {
            $file = public_path("uploads/") . $product->image;

            if (file_exists($file)) {
                unlink($file);
            }

            $filename = rand(1, 10000) . time() . "." . $request->image->getClientOriginalName();
            $request->image->move(public_path("uploads"), $filename);
            $product->image = $filename;
        }

        $product->save();
        return redirect()->route('admin.product.index')->with("success", "Edit product success!");
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.product.index')->with("success", "Delete product success!");
    }
}
