<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder untuk tabel users
 * Membuat beberapa user dummy untuk testing
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat user-user dummy
     */
    public function run(): void
    {
        // Array data user yang akan dibuat
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@wardes.com',
                'password' => Hash::make('password123'), // Password: password123
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'), // Password: password123
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'), // Password: password123
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('password123'), // Password: password123
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'password' => Hash::make('password123'), // Password: password123
            ],
        ];

        // Loop untuk membuat setiap user
        foreach ($users as $userData) {
            User::create($userData);
        }


    }
}
