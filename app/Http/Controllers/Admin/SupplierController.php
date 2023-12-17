<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::simplePaginate(10);
        $suppliers->withPath('/admin/other/supplier/index');
        return view("admin.modules.supplier.index", ["suppliers" => $suppliers]);
    }

    public function create()
    {
        return view("admin.modules.supplier.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:suppliers,name',
            'email' => 'required|unique:suppliers,email',
            'address' => 'required',
            'phone' => 'required|max:15',
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->save();

        return redirect()->route('admin.supplier.index')->with("success", "Create supplier success!");
    }

    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view("admin.modules.supplier.edit", ["data" => $supplier, "id" => $id]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:suppliers,name,' . $id,
            'email' => 'required|unique:suppliers,email,' . $id,
            'address' => 'required',
            'phone' => 'required|max:15',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->save();

        return redirect()->route('admin.supplier.index')->with("success", "Create supplier success!");
    }

    public function destroy(string $id)
    {
        $category = Supplier::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.supplier.index')->with("success", "Delete category success!");
    }
}
