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
}
