<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy("created_at", 'DESC')->simplePaginate(10);
        $categories->withPath('/admin/category/index');
        return view('admin.modules.category.index', ["categories" => $categories]);
    }

    public function create()
    {
        $categories = Category::orderBy("created_at", 'DESC')->get();
        return view('admin.modules.category.create', ["categories" => $categories]);
    }

    public function store(StoreRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->parent_id = $request->parent_id;
        $category->created_at = Carbon::now();
        $category->updated_at = Carbon::now();
        $category->save();
        return redirect()->route('admin.category.index')->with("success", "Create category success!");
    }

    public function edit(string $id)
    {
        $data = Category::findOrFail($id);
        $categories = Category::get();
        return view("admin.modules.category.edit", ["data" => $data, "id" => $id, "categories" => $categories]);
    }
    public function update(UpdateRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->parent_id = $request->parent_id;
        $category->updated_at = Carbon::now();
        $category->save();
        return redirect()->route('admin.category.index')->with("success", "Edit category success!");
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.category.index')->with("success", "Delete category success!");
    }

    public function checkRelatedCategory(Request $request)
    {
        // count product in category
        $categories = Category::with("product")->findOrFail($request->category_id);
        $countProduct = $categories->product->count();
        $countProductInStock = 0;
        foreach ($categories->product as $product) {
            if ($product->stock_quantity > 0 || $product->store_quantity > 0) {
                $countProductInStock++;
            }
        }

        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "countProduct" => $countProduct, "countProductInStock" => $countProductInStock]);
    }

}
