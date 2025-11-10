<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk tabel categories
 * Membuat data kategori produk dummy
 */
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat beberapa kategori produk
     */
    public function run(): void
    {
        // Array data kategori yang akan dibuat
        $categories = [
            ['nama' => 'Makanan'],
            ['nama' => 'Minuman'],
        ];
        // Loop untuk membuat setiap kategori
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
