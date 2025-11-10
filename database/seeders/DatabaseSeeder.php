<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder - Main Seeder
 * Menjalankan semua seeder untuk mengisi database dengan data dummy
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Method ini akan dijalankan saat perintah: php artisan db:seed
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(CartSeeder::class);
    }
}
