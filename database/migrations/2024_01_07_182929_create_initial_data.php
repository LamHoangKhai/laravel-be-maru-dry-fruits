<?php

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sqlFilePath = base_path("/initial.sql");

        if (File::exists($sqlFilePath)) {
            // Đọc nội dung của tệp tin SQL
            $sql = File::get($sqlFilePath);
            // Thực hiện câu lệnh SQL không được biên dịch
            DB::unprepared($sql);
            $this->warehouse();
        } else {
            // Xử lý khi tệp tin không tồn tại
            echo "File not found: $sqlFilePath";
        }
    }
    public function warehouse()
    {
        $product = Product::get()->toArray();
        $import = [];

        for ($i = 0; $i < count($product); $i++) {
            $import = [
                'product_id' => $product[$i]["id"],
                'supplier_id' => rand(1, 2),
                'input_price' => rand(10, 30) / 10,
                'transaction_type' => 1,
                'quantity' => 200,
                'current_quantity' => 200,
                'expiration_date' => '2024-' . rand(3, 6) . '-' . rand(1, 30),
                'transaction_date' => now(),
                'shipment' => rand(1000, 99999) . Carbon::now()->timestamp,
                'created_at' => now(),
                'updated_at' => now()
            ];
            Warehouse::insert($import);

            $export = [
                'product_id' => $product[$i]["id"],
                'supplier_id' => $import['supplier_id'],
                'input_price' => $import['input_price'],
                'transaction_type' => 2,
                'quantity' => 200,
                'current_quantity' => $import['quantity'] - 200,
                'expiration_date' => $import['expiration_date'],
                'transaction_date' => $import['transaction_date'],
                'shipment' => $import['shipment'],
                'created_at' => now(),
                'updated_at' => now()
            ];
            Warehouse::insert($export);
            $importStore = Warehouse::where([['product_id', $import['product_id']], ['transaction_type', 1]])->first();
            $importStore->current_quantity = $export['current_quantity'];
            $importStore->update();
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
