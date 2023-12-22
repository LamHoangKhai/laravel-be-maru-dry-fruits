<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $import = [];
        for($i = 1 ; $i <= 23; $i++) {
            $import = [
                'product_id' => $i,
                'supplier_id' => rand(1,2),
                'input_price' => rand(0.5,1),
                'transaction_type' => 1,
                'quantity' => 200,
                'current_quantity' => 200,
                'expiration_date' => '2023-12-31',
                'transaction_date' => now(),
                'shipment' => rand(1000,99999) . Carbon::now()->timestamp,
                'created_at' => now(),
                'updated_at' => now()
            ];
            Warehouse::insert($import);

            $export = [
                'product_id' => $i,
                'supplier_id' => $import['supplier_id'],
                'input_price' => $import['input_price'],
                'transaction_type' => 2,
                'quantity' => 20,
                'current_quantity' => $import['quantity'] - 20,
                'expiration_date' => $import['expiration_date'],
                'transaction_date' => $import['transaction_date'],
                'shipment' => $import['shipment'],
                'created_at' => now(),
                'updated_at' => now()
            ];
            Warehouse::insert($export);
        }
    }
}
