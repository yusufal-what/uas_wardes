<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'User Satu',
                'email' => 'user1@warungdesa.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
            [
                'name' => 'User Dua',
                'email' => 'user2@warungdesa.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
        ]);
    }
}