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
        $productId = $request->product;
        $note = $request->note;
        $weights = $request->weight;
        $quantity = $request->quantity;
        $discount = $request->discount;
        $products = Product::whereIn("id", $productId)->get(["id", "name", "price"])->toArray();

        $orderItems = [];
        for ($i = 0; $i < count($productId); $i++) {
            $key = array_search($productId[$i], array_column($products, 'id'));
            $orderItems[$i]["product"] = $products[$key]["id"];
            $orderItems[$i]["name"] = $products[$key]["name"];
            $orderItems[$i]["price"] = $products[$key]["price"];
            $orderItems[$i]["subtotal"] = $products[$key]["price"] * ($weights[$i] * $quantity[$i] / 100); // caculator price item
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
        $subtotal = $request->subtotal;

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
        $order->note = $request->note;
        $order->status = 4;
        $order->created_at = date("Y-m-d H:i:s");
        $order->updated_at = date("Y-m-d H:i:s");
        $order->save();

        // insert order item
        $orderItems = [];
        foreach ($productId as $k => $v) {
            $orderItems[$k]["order_id"] = $order->id;
            $orderItems[$k]["product_id"] = $v;
            $orderItems[$k]["price"] = $subtotal[$k];
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

    // API get list order according to status , search order No. ,user email,phone  ,name
    public function getListOrder(Request $request)
    {
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;
        $select = $request->select;

        $query = Order::with(["product", "user"]);

        // if select  0 get  all status order else  status order  = select
        $query = $select > 0
            ? $query->where("status", "=", $select)
            : $query->where("status", "<=", 3);

        // search order No.,user phone ,email , name 
        $query = $query
            ->whereHas("user", function ($query) use ($search) {
                $query->where("full_name", "like", "%" . $search . "%")
                    ->orWhere("email", "like", "%" . $search . "%")
                    ->orWhere("phone", "like", "%" . $search . "%")
                    ->orWhere("orders.id", "like", "%" . $search . "%");
            });
        //return data
        $result = $query->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }


    //API get products, weight tags
    public function getProduct(Request $request)
    {
        $products = Product::get();
        $weights = WeighTag::orderBy("mass", "ASC")->get();
        $result = ["products" => $products, "weights" => $weights];
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }

    //API get order details
    public function getOrderDetail(Request $request)
    {
        $order = Order::with(["product", "user"])->findOrFail($request->id);

        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $order]);
    }
}
