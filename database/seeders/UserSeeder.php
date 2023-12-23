<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
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
        for ($i = 1; $i <= 4; $i++) {
            $user = new User();
            $user->full_name = $faker->name;
            $user->email = $faker->email;
            $user->password = Hash::make('12345678');
            $user->phone = '12345667';
            $user->address = $faker->address;
            $user->level = 2;
            $user->status = 1;
            $user->save();


            $order_id = Order::count() + 1;
            $order = new Order();

            $order->id = $order_id;
            $order->user_id = $user->id;
            $order->status = 1;
            $order->discount = 0;
            $order->transaction = 1;
            $order->transaction_status = 2;
            $order->email = $user->email;
            $order->full_name = $user->full_name;
            $order->address = $user->address;
            $order->phone = $faker->phoneNumber;
            $order->subtotal = 0;
            $order->total = 0;
            $order->save();

            $order_items = [];
            for ($k = 1; $k <= 3; $k++) {

                $order_items[$k]['product_id'] = rand(1, 20);
                $order_items[$k]['order_id'] = $order->id;
                $order_items[$k]['quantity'] = rand(1, 4);
                $order_items[$k]['weight'] = 250;
                $product = Product::findOrFail($order_items[$k]['product_id']);
                $order_items[$k]['price'] = $product->price * ($order_items[$k]['weight'] / 100 * $order_items[$k]['quantity']);
            }
            OrderItems::insert($order_items);


            $orderItems = OrderItems::where("order_id", $order->id)->get();

            foreach ($orderItems as $item) {
                $order->subtotal += $item->price;
            }
            $order->total = $order->subtotal + ($order->subtotal * $order->discount / 100);
            $order->save();

        }
    }
}
