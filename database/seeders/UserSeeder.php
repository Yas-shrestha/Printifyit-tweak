<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => Str::random(10),
                'email' => 'admin@gmail.com',
                'address' => 'Headquarters',
                'phone' => '9779806630977',
                'role' => 'admin',
                'password' => Hash::make('123456789'),
            ],
            [
                'name' => Str::random(10),
                'email' => 'user@gmail.com',
                'address' => 'Home',
                'phone' => '9779806630977',
                'role' => 'user',
                'password' => Hash::make('123456789'),
            ],

        ]);
    }
}
