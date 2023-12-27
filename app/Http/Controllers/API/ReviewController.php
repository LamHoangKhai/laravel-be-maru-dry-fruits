<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use function PHPUnit\Framework\isEmpty;

class ReviewController extends Controller
{
    public function get_comment(Request $request)
    {
        if(auth('api')->user()) {
            if(auth('api')->user()->status == 2) {
                return response()->json([
                    'message' => 'Your account is locked' ,
                    'status_code' => '901'
                ], 400);
            }
            $review = [
                'content' => $request->content,
                'product_id' => $request->product_id,
                'user_id' => auth('api')->user()->id,
                'date' => Carbon::now()
            ];
            $check = Review::where([['user_id', auth('api')->user()->id], ['product_id', $request->product_id]])->get()->first();
            if (empty($check->content)) {
                if (empty($check->star)) {
                    Review::create($review);
                    return response()->json([
                        'message' => 'Comment successfully'
                    ]);
                } else {
                    Review::where([['user_id', auth('api')->user()->id], ['product_id', $request->product_id]])
                        ->update([
                            'content' => $request->content,
                            'date' => Carbon::now()
                        ]);
                    return response()->json([
                        'message' => 'Comment successfully'
                    ], 400);
                }
            } else {
                return response()->json([
                    'message' => 'You have already commented',
                    'status_code' => '902'
                ]);
            }
        }
        else {
            return response()->json([
                'message' => 'You are not logged in',
                'status_code' => '903'
            ], 401);
        }
    }

    public function get_star(Request $request)
    {
        if(auth('api')->user()) {
            if(auth('api')->user()->status == 2) {
                return response()->json([
                    'message' => 'Your account is locked' ,
                    'status_code' => '901'
                ]);
            }
            $rating = [
                'product_id' => $request->product_id,
                'user_id' => auth('api')->user()->id,
                'date' => Carbon::now(),
                'star' => $request->star
            ];
            $check = Review::where([['user_id', auth('api')->user()->id], ['product_id', $request->product_id]])->first();
            if (empty($check->star) && empty($check->content)) {
                Review::insert($rating);

                $totalStar = Review::where('product_id', $request->product_id)->sum('star');
                $countRating = Review::where([['product_id', $request->product_id], ['star', '>', 0]])->count();
                $averageStar = round($totalStar / $countRating, 1);
                Product::where('id', $request->product_id)->update([
                    'star' => $averageStar
                ]);

                return response()->json([
                    'message' => 'Rating succesfully'
                ]);
            }
            Review::select('id')->where([['user_id', auth('api')->user()->id], ['product_id', $request->product_id]])
                ->update([
                    'star' => $request->star,
                    'date' => Carbon::now()
                ]);

            $totalStar = Review::where('product_id', $request->product_id)->sum('star');
            $countRating = Review::where([['product_id', $request->product_id], ['star', '>', 0]])->count();
            $averageStar = round($totalStar / $countRating, 1);
            Product::where('id', $request->product_id)->update([
                'star' => $averageStar
            ]);

            return response()->json([
                'message' => 'Rating successfully'
            ]);
        }
        else {
            return response()->json([
                'message' => 'You are not logged in',
                'status_code' => '903'
            ]);
        }
    }

    // public function return_review(Request $request) {
        
    //     $comments = Review::with("product")->select('user_id', 'content', 'star', 'date', 'product_id')->get();
    //     $dataComment = [];
    //     foreach($comments as $comment) {
    //         $full_name = User::select('full_name')->where('id', $comment->user_id)->get();
    //         $dataComment[] = [
    //             'full_name' => $full_name[0]->full_name,
    //             'content' => $comment->content,
    //             'star' => $comment->star,
    //             'date' => $comment->date,
    //             'product_id' => $comment->product_id,
    //         ];
    //     }
    //     return response()->json([
    //         'data' => $dataComment
    //     ],200);
    // }
}
