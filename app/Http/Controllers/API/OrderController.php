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
        $order->created_at = date("Y-m-d h:i:s");
        $order->updated_at = date("Y-m-d h:i:s");
        $order->save();
        

        // Save order item
        $orderID = $order->id;

        $product_id = $request->product_id;
        $price = $request->price;
        $weight = $request->weight;
        $quantity = $request->quantity;
        if (is_array($product_id)) {
            foreach ($product_id as $product) {
                $id = $product['id'];
                $price = $product['price'];
                $weight = $product['weight'];
                $quantity = $product['quantity'];

                $orderDetail = [
                    'product_id' => $id,
                    'order_id' => $orderID,
                    'price' => $price,
                    'weight' => $weight,
                    'quantity' => $quantity
                ];
                OrderItems::insert($orderDetail);
            }
        } else {
            $orderDetail = [
                'product_id' => $product_id,
                'order_id' => $orderID,
                'price' => $price,
                'weight' => $weight,
                'quantity' => $quantity
            ];
            OrderItems::insert($orderDetail);
        }
        return response()->json([
            'message' => 'Checkout successfully',
            'order' => $order,
            'orderDetail' => $orderDetail
        ], 200);
    }
}
