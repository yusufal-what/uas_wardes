<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk tabel items (products)
 * Membuat data produk dummy dengan berbagai kategori
 */
class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat produk-produk dummy
     */
    public function run(): void
    {
        // Ambil semua kategori yang ada
        $categories = Category::all();

        // Cek apakah ada kategori, jika tidak jalankan CategorySeeder dulu
        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        // Array data produk yang akan dibuat
        // Format: [nama, harga, category_nama]
        $items = [
            // Makanan
            ['Nasi Goreng Spesial', 25000, 'Makanan'],
            ['Mie Ayam Bakso', 20000, 'Makanan'],
            ['Ayam Geprek Sambal Matah', 28000, 'Makanan'],
            ['Sate Ayam 10 Tusuk', 35000, 'Makanan'],
            ['Gado-Gado Jakarta', 22000, 'Makanan'],
            ['Soto Betawi', 30000, 'Makanan'],
            ['Rendang Daging Sapi', 45000, 'Makanan'],
            ['Nasi Uduk Komplit', 25000, 'Makanan'],
            ['Bakso Urat Jumbo', 28000, 'Makanan'],
            ['Ketoprak Tauge', 18000, 'Makanan'],
            ['Pecel Lele Sambal Terasi', 22000, 'Makanan'],
            ['Nasi Rawon Daging', 32000, 'Makanan'],
            ['Ayam Bakar Madu', 35000, 'Makanan'],
            ['Sop Buntut', 55000, 'Makanan'],
            ['Nasi Kuning Tumpeng Mini', 40000, 'Makanan'],
            ['Bubur Ayam Spesial', 18000, 'Makanan'],
            ['Martabak Manis Coklat Keju', 45000, 'Makanan'],
            ['Martabak Telur Daging', 35000, 'Makanan'],
            ['Pizza Margherita Medium', 65000, 'Makanan'],
            ['Burger Beef Cheese', 38000, 'Makanan'],
            ['Kebab Turki Original', 25000, 'Makanan'],
            ['Dimsum Mix 10 Pcs', 40000, 'Makanan'],
            ['Roti Bakar Coklat Pisang', 22000, 'Makanan'],
            ['Donat Kentang 6 Pcs', 30000, 'Makanan'],
            ['Kue Lumpur 5 Pcs', 25000, 'Makanan'],
            ['Bolu Kukus Pandan', 28000, 'Makanan'],
            ['Brownies Coklat Keju', 35000, 'Makanan'],
            ['Risoles Mayo Isi 10', 30000, 'Makanan'],
            ['Pastel Goreng Isi 8', 25000, 'Makanan'],
            ['Lemper Ayam Isi 10', 28000, 'Makanan'],
            
            // Minuman
            ['Es Teh Manis Jumbo', 8000, 'Minuman'],
            ['Es Jeruk Peras Segar', 12000, 'Minuman'],
            ['Jus Alpukat Kental', 18000, 'Minuman'],
            ['Jus Mangga Harum Manis', 16000, 'Minuman'],
            ['Jus Strawberry Fresh', 20000, 'Minuman'],
            ['Es Kelapa Muda Murni', 15000, 'Minuman'],
            ['Es Campur Komplit', 18000, 'Minuman'],
            ['Es Cincau Hitam Manis', 10000, 'Minuman'],
            ['Es Teler 77', 22000, 'Minuman'],
            ['Es Cendol Durian', 20000, 'Minuman'],
            ['Kopi Hitam Robusta', 12000, 'Minuman'],
            ['Kopi Susu Gula Aren', 18000, 'Minuman'],
            ['Cappuccino Latte', 22000, 'Minuman'],
            ['Mochaccino Hot', 24000, 'Minuman'],
            ['Teh Tarik Original', 15000, 'Minuman'],
            ['Thai Tea Original', 16000, 'Minuman'],
            ['Coklat Panas Susu', 18000, 'Minuman'],
            ['Milkshake Vanilla', 25000, 'Minuman'],
            ['Milkshake Strawberry', 26000, 'Minuman'],
            ['Smoothie Mangga', 24000, 'Minuman'],
            ['Lemon Tea Ice', 14000, 'Minuman'],
            ['Green Tea Latte', 20000, 'Minuman'],
            ['Red Velvet Latte', 26000, 'Minuman'],
            ['Matcha Latte Ice', 24000, 'Minuman'],
            ['Es Kopi Susu Tetangga', 15000, 'Minuman'],
            ['Wedang Jahe Hangat', 12000, 'Minuman'],
            ['Bajigur Bandung', 15000, 'Minuman'],
            ['Sekoteng Komplit', 18000, 'Minuman'],
            ['Air Mineral 600ml', 5000, 'Minuman'],
            ['Teh Botol Sosro', 6000, 'Minuman'],
        ];

        // Loop untuk membuat setiap produk
        foreach ($items as $itemData) {
            // Cari kategori berdasarkan nama
            $category = $categories->where('nama', $itemData[2])->first();
            
            // Jika kategori ditemukan, buat produk
            if ($category) {
                Item::create([
                    'nama' => $itemData[0],
                    'harga' => $itemData[1],
                    'category_id' => $category->id,
                    'gambar' => null, // Gambar kosong, bisa diupload manual nanti
                ]);
            }
        }
    }
}
