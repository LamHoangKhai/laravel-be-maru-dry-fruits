<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
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
        $products = $query->with("category", "weightTags")
        ->select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature')
        ->orderBy("created_at", "desc")->paginate(12);
        
        return response()->json([
            'data' => $products
        ], 200);
    }

    public function product_details(Request $request)
    {
        $product_id = $request->product_id;
        $product_detail = Product::with('weightTags', 'reviews')
        ->select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature')
        ->where('id', $product_id)->get();
        return response()->json([
            'data' => $product_detail
        ]);
    }

    public function highest_rating_products()
    {
        $highestRatingProducts = Product::with('weightTags')->orderBy('star', 'desc')
            ->select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature')
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
        ->select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature')
        ->where('feature', 1)->limit(5)->get();
        return response()->json([
            'data' => $featured_products
        ]);
    }

    public function search_product(Request $request)
    {
        $search = $request->search_product;
        $product = Product::
        select('id', 'category_id', 'name', 'image', 'description', 'nutrition_detail', 'price', 'feature')
        ->where("name", "like", "%" . $search . "%")->get();
        return response()->json([
            'data' => $product
        ]);
    }
}
