<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    public function allproduct(Request $request)
    {
        $category = $request->category;
        $query = new Product();
        if ($category > 0) {
            $query = $query->where("category_id", $category);
        }
        
        if($request->search != '') {
            $query = $query->where("name", "like", "%" . $request->search . "%");
        }
        // Sort by price from high to low
        if($request->filter == 2) {
            $query = $query->orderBy('price', 'desc');
        }
        
        // Sort by price from low to high
        if($request->filter == 1) {
            $query = $query->orderBy('price', 'asc');
        }
        $products = $query->with("category", "weightTags")
            ->select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature', "star", "sumary")
            ->orderBy("created_at", "desc")->paginate(12);

        return response()->json([
            'data' => $products
        ], 200);
    }

    public function product_details(Request $request)
    {
        $product_id = $request->product_id;
        $product_detail = Product::with('weightTags', 'reviews')
            ->select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature', "star", "sumary")
            ->where('id', $product_id)->get();
        foreach($product_detail[0]['reviews'] as $cut_user_id) {
            unset($cut_user_id['user_id']);
            unset($cut_user_id['user']['id']);
        }
        return response()->json([
            'data' =>  $product_detail
        ]);
    }

    public function highest_rating_products()
    {
        $highestRatingProducts = Product::with('weightTags')->orderBy('star', 'desc')
            ->select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature', "star", "sumary")
            ->whereIn('star', [4, 5])
            ->limit(10)
            ->get();
        return response()->json([
            'data' => $highestRatingProducts
        ]);
    }

    public function featured_products()
    {
        $featured_products = Product::with('weightTags')
            ->select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature', "star", "sumary")
            ->where('feature', 1)->limit(5)->get();
        return response()->json([
            'data' => $featured_products
        ]);
    }

}
