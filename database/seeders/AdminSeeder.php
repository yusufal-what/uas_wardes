<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin Warung Desa',
            'email' => 'admin@warungdesa.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@warungdesa.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
