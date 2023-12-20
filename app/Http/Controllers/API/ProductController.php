<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allproduct(Request $request)
    {
        $category = $request->category;
        $query = new Product();
        if ($category > 0) {
            $query = $query->where("category_id", $category);
        }
        $result = $query->get();

        return response()->json([
            'product' => $result
        ], 200);
    }

    public function product_details(Request $request)
    {
        $product_id = $request->product_id;
        $product_detail = Product::where('id', $product_id)->get();
        return response()->json([
            'product_detail' => $product_detail
        ]);
    }

    public function product($category_id)
    {
        $products = Product::where([['category_id', $category_id], ['status', 1]])
            ->get();
        return response()->json([
            'product' => $products
        ], 200);
    }

    public function highest_rating_products()
    {
        $highestRatingProducts = Product::orderBy('star', 'desc')
            ->whereIn('star', [4, 5])
            ->limit(10)
            ->get();
        return response()->json([
            'top10Product' => $highestRatingProducts
        ]);
    }

    public function featured_products()
    {
        $featured_products = Product::where('feature', 1)->limit(5)->get();
        return response()->json([
            'featuredProduct' => $featured_products
        ]);
    }
}
