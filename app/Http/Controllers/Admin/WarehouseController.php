<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
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
        $query = Warehouse::where([["transaction_type", "=", 1]]);
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;

        //return data
        $result = $query->with(['supplier', 'product'])->orderBy("current_quantity", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }
    //create import 
    public function importStore(Request $request)
    {

        $request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'expiration_date' => 'required|date|after:now',
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


        return redirect()->route('admin.warehouse.import')->with("success", "Create import success!");
    }

    //edit and update import
    public function edit(string $id)
    {
        $import = Warehouse::findOrfail($id);
        $suppliers = Supplier::get();
        $products = Product::get();

        $checkExport = Warehouse::where([["shipment", "=", $import->shipment], ["transaction_type", "=", 2]])->first();

        if (is_null($checkExport) && Auth::guard("web")->user()->id == "maruDr-yfRui-tspRo-jectfORFOU-Rmembe") {
            return view("admin.modules.warehouse.edit-import", ["data" => $import, "id" => $id, "suppliers" => $suppliers, "products" => $products]);
        }

        $mess = $checkExport ? "Cannot edit import has export ticket!" : "Not allow edit!";
        return redirect()->route("admin.warehouse.import")->with("error", $mess);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'expiration_date' => 'required|date|after:now',
        ]);

        $import = Warehouse::findOrfail($id);
        $import->product_id = $request->product_id;
        $import->supplier_id = $request->supplier_id;
        $import->quantity = $request->quantity;
        $import->expiration_date = $request->expiration_date;
        $import->note = $request->note;
        $import->updated_at = date("Y-m-d h:i:s");
        $import->update();

        return redirect()->route('admin.warehouse.import')->with("success", "Update success!");
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


        $import = Warehouse::where("shipment", $request->shipment)->first();

        $request->validate([
            'product_id' => 'required',
            'shipment' => 'required',
            'quantity' => 'required|numeric|gt:0|lte:' . $import->current_quantity,
        ]);



        if ($import->current_quantity < $request->quantity) {

        }


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



        // update current quantity import
        $findLastestExport = Warehouse::where([["shipment", "=", $request->shipment]
            , ["transaction_type", "=", 2]
            , ["product_id", "=", $request->product_id]])->
            orderBy("created_at", "DESC")->first();
        $import->current_quantity = $findLastestExport->current_quantity;
        $import->update();


        return redirect()->route('admin.warehouse.export')->with("success", "Create export success!");
    }

    //  end export
}
