<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product() {
        $products = Product::with('category')->get();
        return response()->json([
            'product' => $products
        ],200);
    }
}
