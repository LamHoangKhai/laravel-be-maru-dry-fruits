<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $checkoutProduct = $request->all();
        $export_data = [];
        $stock_quantity = Product::find($request->product_id);
        
        foreach ($checkoutProduct as $product) {
            $product_id = is_array($product) ? $product['product_id'] : $checkoutProduct['product_id'];
            $quantity = is_array($product) ? $product['quantity'] : $checkoutProduct['quantity'];

            foreach ($stock_quantity as $dataProduct) {
                $dataProductID = is_array($dataProduct) ? $dataProduct['id'] : $stock_quantity['id'];
                $stockQuantity = is_array($dataProduct) ? $dataProduct['stock_quantity'] : $stock_quantity['stock_quantity'];
                $data = is_array($dataProduct) ? $dataProduct : $stock_quantity;
                if ($dataProductID == $product_id) {
                    if($stockQuantity < $quantity) {
                        return response()->json([
                            'message' => 'Stock quantity of this product must be bigger than quantity'
                        ]);
                    }
                    else {
                        $stockQuantity -= $quantity;
                        $data->update([
                            'stock_quantity' => $stockQuantity
                        ]);
                        break;
                    }
                }
            }

            $now = Carbon::now();
            $closestExpirationProduct = Transaction::where('product_id', $product_id)
                ->where('expiration_date', '>', $now)
                ->orderBy('expiration_date')
                ->limit(1)
                ->get();

            $export_data[] = [
                'product_id' => $closestExpirationProduct[0]['product_id'],
                'quantity' => $quantity,
                'transaction_type' => 2,
                'transaction_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'shipment' => $closestExpirationProduct[0]['shipment'],
                'expiration_date' => $closestExpirationProduct[0]['expiration_date'],
            ];

            if (!is_array($product)) {
                break;
            }
        }
        Transaction::insert($export_data);
        return response()->json([
            'message' => 'Export successfully'
        ]);
    }
}
