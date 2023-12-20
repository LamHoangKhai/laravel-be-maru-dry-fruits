<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $idDefault = "maruDr-yfRui-tspRo-jectfORFOU-Rmembe";
        DB::table('users')->insert([
            "id" => $idDefault,
            'full_name' => "Superadmin",
            'email' => "administrator" . '@gmail.com',
            'password' => Hash::make('administrator'),
            'level' => '1',
            'status' => '1',
        ]);

        // $dataUser = [];
        // for ($i = 1; $i <= 95; $i++) {
        //     $dataUser[] = [
        //         'id' => $i,
        //         'full_name' => $faker->name,
        //         'password' => Hash::make('12345678'),
        //         'email' => $faker->email,
        //         'level' => 2,
        //         'status' => 1,
        //     ];
        // }
        // DB::table('users')->insert($dataUser);
    }
}
