<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Product_Weight;
use Exception;
use Carbon\Carbon;

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

    public function history()
    {
        return view("admin.modules.order.history");
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Product_Weight::with(["weight_tag", "product"])->get();
        return view("admin.modules.order.create", ["products" => $data]);
    }

    public function checking(Request $request)
    {
        $request->validate([
            "products" => "required"
        ]);
        $productId = $request->products;
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
        $order->full_name = "";
        $order->email = "";
        $order->phone = "";
        $order->address = "";
        $order->subtotal = $request->subtotalOrder;
        $order->discount = $request->discount;
        $order->total = $request->total;
        $order->transaction = 1;
        $order->transaction_status = 1;
        $order->note = $request->note;
        $order->status = 4;
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();
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

        return redirect()->route("admin.order.history")->with("success", "Create order success!");
    }

    //API get product
    public function product(Request $request)
    {
        $product = Product_Weight::with(["weight_tag", "product"])->findOrFail($request->id)->toArray();
        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $product]);
    }



    // API get list order according to status , search order No. ,user email,phone  ,name
    public function getListOrder(Request $request)
    {
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;
        $select = $request->select;

        $query = Order::with("user");

        // if select  0 get  all status order else  status order  = select
        $query = $select > 0
            ? $query->where("status", "=", $select)
            : $query->where("status", "<=", 3);

        // search order No.,user phone ,email , name 
        $query = $query
            ->whereHas("user", function ($query) use ($search) {
                $query->where("email", "like", "%" . $search . "%")
                    ->orWhere("phone", "like", "%" . $search . "%")
                    ->orWhere("orders.id", "like", "%" . $search . "%")
                    ->orWhere("orders.phone", "like", "%" . $search . "%");
            });
        //return data
        $result = $query->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $result]);
    }

    public function getHistoryOrder(Request $request)
    {
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;
        $select = $request->select;
        $date = $request->date;
        $query = Order::with("user");

        if ($date) {
            $query = $query->whereDate('updated_at', $date);
        }


        // if select  0 get  all status order else  status order  = select
        $query = $select > 0
            ? $query->where("status", "=", $select)
            : $query->where("status", ">", 3);



        // search order No.,user phone ,email , name 
        $query = $query
            ->whereHas("user", function ($query) use ($search) {
                $query->where("email", "like", "%" . $search . "%")
                    ->orWhere("phone", "like", "%" . $search . "%")
                    ->orWhere("orders.id", "like", "%" . $search . "%")
                    ->orWhere("orders.phone", "like", "%" . $search . "%");
            });
        //return data
        $result = $query->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $result]);
    }







    //API get order details
    public function getOrderDetail(Request $request)
    {
        $order = Order::with(["order_items", "user"])->findOrFail($request->id);
        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $order]);
    }

    public function cancelOrder(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->status = 5;
        $order->updated_at = Carbon::now();
        $order->save();
        return response()->json(['status_code' => 200, 'msg' => "Success"]);
    }

    public function updateStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $currentStatus = $order->status;
        $order->status = $currentStatus + 1;
        $order->updated_at = Carbon::now();
        if ($order->status == 4) {
            $order->transaction_status = 1;
        }
        $order->save();
        return response()->json(['status_code' => 200, 'msg' => "Success"]);
    }
}
