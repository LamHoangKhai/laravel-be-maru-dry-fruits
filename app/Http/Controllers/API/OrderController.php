<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        // Save order
        $order = new Order();
        $order->email =  $request->email;
        $order->full_name = $request->full_name;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->transaction = $request->transaction;
        $order->subtotal = $request->subtotal;
        $order->user_id = auth('api')->user()->id;
        $order->status = 1;
        $order->total = $request->subtotal + 35000;
        $order->transaction_status = 1;
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();
        $order->save();


        // Save order item
        $orderID = $order->id;

        $items = $request->order_items;
        $orderDetail=[];
            foreach ($items as $item) {
                $id = $item['product_id'];
                $price = $item['price'];
                $weight = $item['weight'];
                $quantity = $item['quantity'];
                $orderDetail[] = [
                    'product_id' => $id,
                    'order_id' => $orderID,
                    'price' => $price,
                    'weight' => $weight,
                    'quantity' => $quantity
                ];
            }
        OrderItems::insert($orderDetail);
        return response()->json([
            'message' => 'Checkout successfully',
            'order' => $order,
            'orderDetail' => $orderDetail
        ], 200);
    }
    public function history_order() {
        $user = auth('api')->user()->id;
        $order = Order::where('user_id', $user)->get();
        $history_order = [];
        foreach($order as $order) {
            $quantity = OrderItems::where('order_id', $order->id)->get();
            
            $history_order[] = [
                'order_id' => $order->id,
                'status' => $order->status,
                'subtotal' => $order->subtotal,
                'created_at' => $order->created_at,
                'quantity' => count($quantity)
            ];
        }
        return response()->json([
            'history_order' => $history_order
        ]);
    }
    public function history_order_details(Request $request) {
        $order_id = $request->order_id;
        $history_order = OrderItems::withTrashed()->where('order_id', $order_id)->get();
        $history_order_details = [];
        foreach($history_order as $order_item) {
                $product = Product::where('id', $order_item->product_id)->get();
                $history_order_details[] = [
                    'name' => $product[0]->name,
                    'price' => $order_item->price,
                    'weight' => $order_item->weight,
                    'quantity' => $order_item->quantity,
                    'total' => $order_item->price/100 * $order_item->weight * $order_item->quantity
                ];
        }
        return response()->json([
            'history_order_details' => $history_order_details
        ]);
    }
}
