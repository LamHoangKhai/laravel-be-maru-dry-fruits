public function index()
    {
        $transactions = Transaction::where('current_quantity', '>', 0)->get();
        return view('admin.modules.transaction.index', [
            'transactions' => $transactions
        ]);
    }

    public function create()
    {
        return view('admin.modules.transaction.create');
    }

    public function store(Request $request)
    {
        $requestTransaction = [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'current_quantity' => $request->quantity,
            'transaction_type' => $request->transaction_type,
            'shipment' => $request->shipment,
            'transaction_date' => Carbon::now(),
            'expiration_date' => Carbon::now(),
            'supplier_id' => 1
        ];
        Transaction::create($requestTransaction);
        $product = Product::findOrFail($request->product_id);
        $stock_quantity = $product->stock_quantity + $request->quantity;
        $product->update([
            'stock_quantity' => $stock_quantity
        ]);
        return redirect()->route('admin.transaction.index');
    }

    public function export(Request $request)
    {
        $export_product = $request->export_product;
        $export_quantity = $request->export_quantity;
        $export_shipment = $request->export_shipment;

        $stock_quantity = Product::select('stock_quantity')->where('id', $export_product)->get()[0]->stock_quantity;
        if ($stock_quantity < $export_quantity) {
            return redirect()->route('admin.transaction.index')->with('message', 'This product isn\'t enough to export');
        } else {
            $transactionExportProduct = Transaction::where('product_id', $export_product)
                ->where('shipment', $export_shipment)->first();
            if ($transactionExportProduct->current_quantity < $export_quantity) {
                return redirect()->route('admin.transaction.index')->with('message', 'This shipment isn\t enough to export');
            } else {
                $transactionInsertExportProduct = [
                    'product_id' => $transactionExportProduct->product_id,
                    'quantity' => $transactionExportProduct->quantity,
                    'current_quantity' => $transactionExportProduct->current_quantity - $export_quantity,
                    'transaction_type' => 2,
                    'transaction_date' => Carbon::now(),
                    'shipment' => $transactionExportProduct->shipment,
                    'expiration_date' => $transactionExportProduct->expiration_date,
                    'supplier_id' => $transactionExportProduct->suppler_id
                ];
                Transaction::insert($transactionInsertExportProduct);
                $transactionExportProduct->update([
                    'current_quantity' => $transactionExportProduct->current_quantity - $export_quantity,
                ]);
                $stockProduct = Product::findOrFail($export_product);
                $storeInQuantity = $stockProduct->store_in_quantity + $export_quantity;
                $stockProductID = $stockProduct->stock_quantity - $export_quantity;
                $stockProduct->update([
                    'store_in_quantity' => $storeInQuantity,
                    'stock_quantity' => $stockProductID
                ]);
                return redirect()->route('admin.transaction.index')->with('success', 'Export succesfully');
            }
        }
    }