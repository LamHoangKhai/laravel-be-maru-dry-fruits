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
        $products = $query->get();

        return response()->json([
            'product' => $products
        ], 200);
    }

    public function product_details(Request $request)
    {
        $product_id = $request->product_id;
        $product_detail = Product::with('weightTags')->where('id', $product_id)->get();
        return response()->json([
            'product_detail' => $product_detail
        ]);
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

    public function search_product(Request $request) {
        $search = $request->search_product;
        $product = Product::where("name", "like", "%" . $search . "%")->get();
        return response()->json([
            'product' => $product
        ]);
    }
}
