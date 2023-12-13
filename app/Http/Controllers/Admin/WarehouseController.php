<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function import()
    {
        $suppliers = Supplier::get();
        $products = Product::get();
        return view("admin.modules.warehouse.import", ["suppliers" => $suppliers, "products" => $products]);
    }
    //api get imports for ajax
    public function getImports(Request $request)
    {
        $query = Warehouse::where([["transaction_type", "=", 1], ["current_quantity", ">", 0]]);
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

        $import = new Warehouse();
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

        return redirect()->route('admin.warehouse.import')->with("success", "Create import success!");
    }
    //  end import


    //  export

    public function export()
    {
        $products = Product::get();
        return view("admin.modules.warehouse.export", ['products' => $products]);
    }

    //find imports
    public function findImport(Request $request)
    {
        $import = Warehouse::with("supplier")
            ->where([["product_id", $request->product_id], ["transaction_type", "=", 1], ["current_quantity", ">", 0]])
            ->get();

        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $import]);
    }

    //api get exports for ajax
    public function getExports(Request $request)
    {
        $query = Warehouse::where("transaction_type", "=", 2);
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
        $import = Warehouse::where("shipment", $request->shipment)->first();

        $export = new Warehouse();
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

        return redirect()->route('admin.warehouse.export')->with("success", "Create export success!");
    }

    //  end export
}
