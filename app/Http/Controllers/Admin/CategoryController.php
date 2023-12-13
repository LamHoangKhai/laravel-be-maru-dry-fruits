<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy("created_at", 'DESC')->simplePaginate(10);
        $categories->withPath('/admin/category/index');
        return view('admin.modules.category.index', ["categories" => $categories]);
    }

    public function store(StoreRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->parent_id = $request->parent_id;
        $category->created_at = date("Y-m-d h:i:s");
        $category->updated_at = date("Y-m-d h:i:s");
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
        $category->updated_at = date("Y-m-d h:i:s");
        $category->save();
        return redirect()->route('admin.category.index')->with("success", "Edit category success!");
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.category.index')->with("success", "Delete category success!");
    }
}
