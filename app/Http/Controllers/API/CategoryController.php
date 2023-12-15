<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category($parent_id = 0) {
        $categories = $this->getCategories($parent_id);
        return response()->json([
            'categories' => $categories
        ],200);
    }

    public function getCategories($parent_id = 0) {
        $categories = Category::where('parent_id', $parent_id)->get();
        foreach($categories as $category) {
            $category->children = $this->getCategories($category->id);
        }
        return $categories;
    }
}
