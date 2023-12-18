<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\WeighTag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.modules.order.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.modules.order.create");
    }

    public function checking(Request $request)
    {
        $request->validate([
            "product" => "required"
        ]);
        $note = $request->note;

        $weights = $request->weight;
        $quantity = $request->quantity;
        $discount = $request->discount;
        $products = Product::whereIn("id", $request->product)->get(["id", "name", "price"]);
        $orderItems = [];
        for ($i = 0; $i < count($products); $i++) {
            $orderItems[$i]["product"] = $products[$i]->id;
            $orderItems[$i]["name"] = $products[$i]->name;
            $orderItems[$i]["price"] = $products[$i]->price;
            $orderItems[$i]["subtotal"] = $products[$i]->price * ($weights[$i] * $quantity[$i] / 100); // caculator price item
            $orderItems[$i]["weight"] = $weights[$i];
            $orderItems[$i]["quantity"] = $quantity[$i];
        }

        return view("admin.modules.order.checking", ['orderItems' => $orderItems, "discount" => $discount, "note" => $note]);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $productId = $request->product;
        $weight = $request->weight;
        $quantity = $request->quantity;
        $price = $request->price;

        // insert order 
        $order = new Order();
        $order->user_id = Auth::guard("web")->user()->id;
        $order->full_name = "sold offline";
        $order->email = "empty";
        $order->phone = "empty";
        $order->address = "empty";
        $order->subtotal = $request->subtotal;
        $order->discount = $request->discount;
        $order->total = $request->total;
        $order->transaction = 1;
        $order->transaction_status = 1;
        // $order->note = $request->note;
        $order->status = 4;
        $order->created_at = date("Y-m-d h:i:s");
        $order->updated_at = date("Y-m-d h:i:s");
        $order->save();

        // insert order item
        $orderItems = [];
        foreach ($productId as $k => $v) {
            $orderItems[$k]["order_id"] = $order->id;
            $orderItems[$k]["product_id"] = $v;
            $orderItems[$k]["price"] = $price[$k];
            $orderItems[$k]["weight"] = $weight[$k];
            $orderItems[$k]["quantity"] = $quantity[$k];
        }
        OrderItems::insert($orderItems);
        return redirect()->route("admin.order.index")->with("success", "Create order success!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function product(Request $request)
    {

        // if (isset($request->list_product)) {
        //     $products = Product::whreIn("id",);
        //     return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $products]);
        // }

        $products = Product::get();
        $weights = WeighTag::get();
        $result = ["products" => $products, "weights" => $weights];
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }

}
