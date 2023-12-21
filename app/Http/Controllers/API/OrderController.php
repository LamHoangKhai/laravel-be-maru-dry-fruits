<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        // Save order
        $order = new Order();
        $order->email = $request->email;
        $order->full_name = $request->full_name;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->transaction = $request->transaction;
        $order->subtotal = $request->subtotal;
        $order->user_id = auth('api')->user()->id;
        $order->total = $request->subtotal + 35000;
        $order->status = 1;
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
}
