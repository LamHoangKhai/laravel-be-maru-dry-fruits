<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProduct() {
        $products = Product::all();
        return response()->json([
            'product' => $products
        ],200);
    }

    public function product($category_id) {
        $products = Product::where([['category_id', $category_id], ['status', 1]])
        ->get();
        return response()->json([
            'product' => $products
        ],200);
    }

    public function highest_rating_products ($category_id) {
        $highestRatingProducts = Product::orderBy('star', 'desc')
        ->where('category_id', $category_id)
        ->limit(5)
        ->get();
        return response()->json([
            'top5Product' => $highestRatingProducts
        ],200);
    }

    public function featured_products() {
        $featured_products = Product::where(['feature', 1])->limit(5)->get();
        return response()->json([
            'featuredProduct' => $featured_products
        ],200);
    }
}
