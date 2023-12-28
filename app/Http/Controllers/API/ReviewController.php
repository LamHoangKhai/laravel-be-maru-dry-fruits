<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use function PHPUnit\Framework\isEmpty;

class ReviewController extends Controller
{
    public function review(Request $request)
    {
        $review = [
            'content' => $request->content,
            'star' => $request->star,
            'product_id' => $request->product_id,
            'user_id' => auth('api')->user()->id,
            'date' => Carbon::now()
        ];

        $check = Review::where([['user_id', auth('api')->user()->id], ['product_id', $request->product_id]])->get()->first();
        if (empty($check->content) && empty($check->star)) {
            Review::create($review);
            $totalStar = Review::where('product_id', $request->product_id)->sum('star');
            $countRating = Review::where([['product_id', $request->product_id], ['star', '>', 0]])->count();
            $averageStar = $totalStar / $countRating;
            Product::where('id', $request->product_id)->update([
                'star' => $averageStar
            ]);
            return response()->json([
                'message' => 'Review successfully'
            ]);
        }
    }

    public function check(Request $request)
    {
        if (auth('api')->user()) {
            if (auth('api')->user()->status == 2) {
                return response()->json([
                    'message' => 'Your account is locked',
                    'status_code' => '901'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Please login',
                'status_code' => '903'
            ]);
        }
        $check = Review::where([['user_id', auth('api')->user()->id], ['product_id', $request->product_id]])->get()->first();
        if(!empty($check->content) || !empty($check->star)) {
            return response()->json([
                'message' => 'You have already reviewed',
                'status_code' => '902'
            ]);
        }
        $ordered = Order::with('order_items')->where('user_id', auth('api')->user()->id)->get();

        $is_exist_order_items = false;
        foreach ($ordered as $order_items) {
            foreach ($order_items['order_items'] as $order_item) {
                if ($order_item->product_id == $request->product_id) {
                    $is_exist_order_items = true;
                    break;
                }
            }
        }
        if (!$is_exist_order_items) {
            return response()->json([
                'message' => 'Please buy this product to review',
                'status_code' => '904'
            ]);
        }
    }
}
