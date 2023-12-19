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


    //view log import/export
    public function log(string $id)
    {
        $product = Product::findOrFail($id);
        $inputPrice = Warehouse::where("product_id", $id)->max("input_price");
        return view("admin.modules.product.log", ["id" => $id, "product" => $product, "inputPrice" => $inputPrice]);
    }


    //view create import
    public function createImport(string $id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::get();
        return view("admin.modules.import.create", ["product" => $product, "suppliers" => $suppliers]);
    }

    //create import 
    public function importStore(Request $request)
    {

        $request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'input_price' => 'required|numeric',
            'expiration_date' => 'required|date|after:now',
        ]);

        $import = new Warehouse();
        $import->product_id = $request->product_id;
        $import->supplier_id = $request->supplier_id;
        $import->quantity = $request->quantity;
        $import->current_quantity = $request->quantity;
        $import->expiration_date = $request->expiration_date;
        $import->input_price = $request->input_price;
        $import->note = $request->note;
        $import->shipment = time();
        $import->transaction_type = 1;
        $import->transaction_date = date("Y-m-d H:i:s");
        $import->created_at = date("Y-m-d H:i:s");
        $import->updated_at = date("Y-m-d H:i:s");
        $import->save();

        return redirect()->route('admin.product.index')->with("success", "Create import success!");
    }

    //view edit import
    public function editImport(string $id)
    {
        $import = Warehouse::findOrfail($id);
        $suppliers = Supplier::get();
        $product = Product::findOrFail($import->product_id);

        $checkExport = Warehouse::where([["shipment", "=", $import->shipment], ["transaction_type", "=", 2]])->first();
        // allowed edit if Superadmin 
        if (is_null($checkExport) && Auth::guard("web")->user()->id == "maruDr-yfRui-tspRo-jectfORFOU-Rmembe") {
            return view("admin.modules.import.edit", ["data" => $import, "id" => $id, "suppliers" => $suppliers, "product" => $product]);
        }

        $mess = $checkExport ? "Cannot edit import has export ticket!" : "Not allow edit!";
        return redirect()->route("admin.product.index")->with("error", $mess);
    }
    // update import
    public function updateImport(Request $request, string $id)
    {
        $request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'expiration_date' => 'required|date|after:now',
        ]);

        $import = Warehouse::findOrfail($id);
        $import->product_id = $request->product_id;
        $import->input_price = $request->input_price;
        $import->supplier_id = $request->supplier_id;
        $import->quantity = $request->quantity;
        $import->expiration_date = $request->expiration_date;
        $import->note = $request->note;
        $import->updated_at = date("Y-m-d H:i:s");
        $import->save();

        return redirect()->route('admin.product.index')->with("success", "Update success!");
    }

    // view create export
    public function createExport(string $id)
    {
        $product = Product::findOrFail($id);
        $imports = Warehouse::with("supplier")
            ->where([["product_id", $product->id], ["transaction_type", "=", 1], ["current_quantity", ">", 0]])->orderBy("expiration_date", "ASC")
            ->get();
        return view("admin.modules.export.create", ["product" => $product, "imports" => $imports]);
    }

    //create export
    public function exportStore(Request $request)
    {
        $import = Warehouse::where("shipment", $request->shipment)->first();

        $request->validate([
            'product_id' => 'required',
            'shipment' => 'required',
            'quantity' => 'required|numeric|gt:0|lte:' . (isset($import) ? $import->current_quantity : 0),
        ]);
        if (!$import) {
            abort(404);
        }

        $export = new Warehouse();
        $export->supplier_id = $import->supplier_id;
        $export->expiration_date = $import->expiration_date;
        $export->input_price = $import->input_price;
        $export->product_id = $request->product_id;
        $export->quantity = $request->quantity;
        $export->shipment = $request->shipment;
        $export->transaction_type = 2;
        $export->transaction_date = date("Y-m-d");
        $export->created_at = date("Y-m-d H:i:s");
        $export->save();

        // update current quantity import
        $findLastestExport = Warehouse::where([["shipment", "=", $request->shipment]
            , ["transaction_type", "=", 2]
            , ["product_id", "=", $request->product_id]])->
            orderBy("created_at", "DESC")->first();
        $import->current_quantity = $findLastestExport->current_quantity;
        $import->update();
        return redirect()->route('admin.product.index')->with("success", "Create export success!");
    }

    //api log import/export 
    public function getLog(Request $request)
    {

        $request->validate([
            'product_id' => 'required'
        ]);

        $query = Warehouse::where("product_id", "=", $request->product_id);
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;

        $query = $query->with(['supplier', 'product']);
        $query = $query->where("shipment", "like", "%" . $search . "%");


        //return data
        $result = $query->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }


}
