<?php

namespace App\Http\Controllers\API;

use App\Events\UserOrder;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
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
            if (auth('api')->user()->status == 2) {
                return response()->json([
                    'message' => 'Your Account Is Locked',
                    'status_code' => '901'
                ]);
            }
            $order_pending_payment = Order::where([['user_id', auth('api')->user()->id], ['transaction_status', 2], ['status', "!=", 5]])->count();
            if ($order_pending_payment >= 3) {
                return response()->json([
                    'message' => 'Please Pay For Your Order To Continue Shopping',
                    'status_code' => '910'
                ]);
            }
            $order = new Order();
            $order->email = auth('api')->user()->email;
            $order->full_name = $request->full_name;
            $order->address = $request->address;
            $order->phone = $request->phone;
            $order->transaction = $request->transaction;
            $order->subtotal = $request->subtotal;
            $order->user_id = auth('api')->user()->id;
            $order->status = 1;
            $order->total = $request->total;
            $order->transaction_status = $request->transaction == 1 ? 2 : 1;
            $order->created_at = Carbon::now();
            $order->updated_at = Carbon::now();
            $order->save();

            $info_user = User::where('id', auth('api')->user()->id)->first();
            if (!$info_user->full_name || !$info_user->address || !$info_user->phone) {
                $update_info = [
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'full_name' => $request->full_name
                ];
                User::where('id', auth('api')->user()->id)->update($update_info);
            }
            // Realtime notification
            event(new UserOrder($order));

            // Mail structure

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

            // Send mail
            try {
                Mail::to($order->email)->send(new SendMail($subject, $body));
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            return response()->json([
                'message' => 'Checkout Successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => "You Are Not Logged In",
                'status_code' => '903'
            ]);
        }
    }
    public function history_order()
    {
        if (auth('api')->user()) {
            $user = auth('api')->user()->id;
            $orders = Order::with('order_items')->where('user_id', $user)->paginate(10);
            foreach ($orders as $cut_user_id) {
                unset($cut_user_id->user_id);
            }
            return response()->json([
                'data' => $orders
            ]);
        }
    }
}
