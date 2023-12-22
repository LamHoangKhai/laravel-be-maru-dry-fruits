<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $data = [];
        for ($i = 2; $i <= 12; $i++) {
            $data = [
                'id' => $i,
                'full_name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('12345678'),
                'phone' => '12345667',
                'address' => $faker->address,
                'level' => 2,
                'status' => 1
            ];
            DB::table('users')->insert($data);

            $user = User::where('id', $i)->get();
            $order = [];
            for ($j = 1; $j <= 2; $j++) {
                $order_id = Order::all();
                $order = [
                    'id'  => count($order_id) + 1,
                    'user_id' => $i,
                    'status' => 1,
                    'subtotal' => rand(1, 150),
                    'discount' => 0,
                    'total' => rand(150, 200),
                    'transaction' => rand(1, 2),
                    'transaction_status' => rand(1, 2),
                    'email' => $user[0]->email,
                    'full_name' => $user[0]->full_name,
                    'address' => $user[0]->address,
                    'phone' => $faker->phoneNumber
                ];
                Order::insert($order);
                for ($k = 1; $k <= 3; $k++) {
                    $order_id = Order::all();
                    $order_items = [
                        'product_id' => rand(1, 20),
                        'order_id' => count($order_id),
                        'price' => 100,
                        'weight' => 250,
                        'quantity' => rand(1, 10),
                    ];
                    OrderItems::insert($order_items);
                }
            }
        }
    }
}
