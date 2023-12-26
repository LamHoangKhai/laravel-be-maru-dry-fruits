<?php

namespace App\Http\Controllers\API;

use App\Events\UserOrder;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        // Save order
        if (auth('api')->user()) {
            $order = new Order();
            $order->email = auth('api')->user()->email;
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

            // Realtime notification
            event(new UserOrder($order));

            // send mail

            $subject = '[MARU DRY FRUITS CONFIRMS ORDER]';
            $body = [
                'dear' => 'Dear' . ' ' . $order->full_name,
                'greeting' => "We extend our sincere gratitude to you for choosing Maru Dry Fruits as your shopping partner. We have received your order and are pleased to inform you that your order has been successfully confirmed.",

                'order_id' => $order->id,
                'date' => $order->created_at,
                'total' => $order->total,
                'transaction' => $order->transaction,
                'full_name' => $order->full_name,
                'address' => $order->address,
                'phone' => $order->phone,

                'end' => "If you have any questions or concerns, please contact us via email at huanbeu555@gmail.com or by phone at 0929090614.

            We sincerely look forward to serving you again and hope that you will be satisfied with our products and services."
            ];
            Mail::to($order->email)->send(new SendMail($subject, $body));
            // Save order item
            $orderID = $order->id;

            $items = $request->order_items;
            $orderDetail = [];
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
            ], 200);
        }
        else {
            return response()->json([
                'message' => "You are not logged in"
            ]);
        }
    }
    public function history_order()
    {
        if(auth('api')->user()) {
            $user = auth('api')->user()->id;
            $order = Order::where('user_id', $user)->get();
            $history_order = [];
            foreach ($order as $order) {
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
                'data' => $history_order
            ],200);
        }
        else {
            return response()->json([
                'message' => 'Ypu are not logged in'
            ]);
        }
    }
    public function history_order_details(Request $request)
    {
        $order_id = $request->order_id;
        $history_order = OrderItems::withTrashed()->where('order_id', $order_id)->get();
        $history_order_details = [];
        foreach ($history_order as $order_item) {
            $product = Product::where('id', $order_item->product_id)->get();
            $history_order_details[] = [
                'name' => $product[0]->name,
                'price' => $order_item->price,
                'weight' => $order_item->weight,
                'quantity' => $order_item->quantity,
                'total' => $order_item->price / 100 * $order_item->weight * $order_item->quantity
            ];
        }
        return response()->json([
            'data' => $history_order_details
        ],200);
    }

}
