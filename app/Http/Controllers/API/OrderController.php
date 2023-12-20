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
        $infoUserCheckout = [
            'email' => $request->email,
            'full_name' => $request->full_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'transaction' => $request->transaction,
            'subtotal' => $request->subtotal,
            'user_id' => auth('api')->user()->id,
            'status' => 1,
            'total' => $request->subtotal + 35000,
            'transaction_status' => 1,
            'created_at' => Carbon::now(),
        ];

        Order::insert($infoUserCheckout);

        
        unset($infoUserCheckout['user_id']);
        return response()->json([
            'message' => 'Checkout successfully',
            'order' => $infoUserCheckout
        ], 200);
    }

    public function order_items(Request $request)
    {
        $latestOrder = Order::latest()->first();

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
                    'order_id' => $latestOrder->id,
                    'price' => $price,
                    'weight' => $weight,
                    'quantity' => $quantity
                ];
                OrderItems::insert($orderDetail);
            }
        } else {
            $orderDetail = [
                'product_id' => $product_id,
                'order_id' => $latestOrder->id,
                'price' => $price,
                'weight' => $weight,
                'quantity' => $quantity
            ];
            OrderItems::insert($orderDetail);
        }
        return response()->json([
            'orderDetail' => $orderDetail
        ]);
    }

}
