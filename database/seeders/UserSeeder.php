<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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

    }
}
