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
        for ($i = 1; $i <= 100; $i++) {
            $user = new User();
            $user->id = $i;
            $user->full_name = $faker->name;
            $user->email = $faker->unique()->email;
            $user->password = Hash::make('12345678');
            $user->phone = '1234567';
            $user->address = $faker->address;
            $user->level = 2;
            $user->status = 1;
            $user->save();
        }
    }
}
