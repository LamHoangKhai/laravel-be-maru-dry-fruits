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
    public function getImports(Request $request)
    {
        $query = Transaction::where([["transaction_type", "=", 1], ["current_quantity", ">", 0]]);
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;

        //return data
        $result = $query->with(['supplier', 'product'])->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);
    }

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

        return view("admin.modules.transaction.import");
    }
    //  end import


    //  export

    public function export()
    {
        return view("admin.modules.transaction.export");
    }


    public function exportStore(Request $request)
    {
        return view("admin.modules.transaction.index");
    }

    //  end export


    //  supplier
    public function supplier()
    {
        $suppliers = Supplier::get();

        return view("admin.modules.transaction.supplier", ["suppliers" => $suppliers]);
    }

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
