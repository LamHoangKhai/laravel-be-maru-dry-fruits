<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //  import
    public function import()
    {
        $suppliers = Supplier::get();
        $products = Product::get();
        return view("admin.modules.transaction.import", ["suppliers" => $suppliers, "products" => $products]);
    }
    //api get imports for ajax
    public function getImports(Request $request)
    {
        $query = Transaction::where([["transaction_type", "=", 1], ["current_quantity", ">", 0]]);
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;

        //return data
        $result = $query->with(['supplier', 'product'])->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }
    //create import 
    public function importStore(Request $request)
    {

        $request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'expiration_date' => 'required',
        ]);

        $import = new Transaction();
        $import->product_id = $request->product_id;
        $import->supplier_id = $request->supplier_id;
        $import->quantity = $request->quantity;
        $import->current_quantity = $request->quantity;
        $import->expiration_date = $request->expiration_date;
        $import->note = $request->note;
        $import->shipment = time();
        $import->transaction_type = 1;
        $import->transaction_date = date("Y-m-d h:i:s");
        $import->created_at = date("Y-m-d h:i:s");
        $import->updated_at = date("Y-m-d h:i:s");
        $import->save();

        // viết trigger ở đây nha huân

        return redirect()->route('admin.transaction.import')->with("success", "Create import success!");
    }
    //  end import


    //  export

    public function export()
    {
        $products = Product::get();
        return view("admin.modules.transaction.export", ['products' => $products]);
    }

    //find imports
    public function findImport(Request $request)
    {
        $import = Transaction::with("supplier")
            ->where([["product_id", $request->product_id], ["transaction_type", "=", 1], ["current_quantity", ">", 0]])
            ->get();

        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $import]);
    }

    //api get exports for ajax
    public function getExports(Request $request)
    {
        $query = Transaction::where("transaction_type", "=", 2);
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;

        //return data
        $result = $query->with(['supplier', 'product'])->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }

    //create export
    public function exportStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'shipment' => 'required',
            'quantity' => 'required|numeric',
        ]);


        $product = Product::findOrFail($request->product_id);
        $import = Transaction::where("shipment", $request->shipment)->first();

        $export = new Transaction();
        $export->supplier_id = $import->supplier_id;
        $export->expiration_date = $import->expiration_date;
        $export->product_id = $request->product_id;
        $export->quantity = $request->quantity;
        $export->shipment = $request->shipment;
        $export->transaction_type = 2;
        $export->transaction_date = date("Y-m-d");
        $export->created_at = date("Y-m-d h:i:s");
        $export->save();


        // viết trigger ở đây nha huân

        return redirect()->route('admin.transaction.export')->with("success", "Create export success!");
    }

    //  end export


    //  supplier
    public function supplier()
    {
        $suppliers = Supplier::get();

        return view("admin.modules.transaction.supplier", ["suppliers" => $suppliers]);
    }

    //create supplier
    public function supplierStore(Request $request)
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

        return redirect()->route('admin.transaction.supplier')->with("success", "Create supplier success!");
    }
    //  end supplier




}
