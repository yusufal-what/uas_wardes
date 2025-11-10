<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk tabel carts dan cart_items
 * Membuat keranjang belanja dummy dengan beberapa produk di dalamnya
 */
class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat cart dan cart items dummy
     */
    public function run(): void
    {
        // Ambil semua user
        $users = User::all();

        // Cek apakah ada user, jika tidak jalankan UserSeeder dulu
        if ($users->isEmpty()) {
            $this->call(UserSeeder::class);
            $users = User::all();
        }

        // Ambil semua item/produk
        $items = Item::all();

        // Cek apakah ada item, jika tidak jalankan ItemSeeder dulu
        if ($items->isEmpty()) {
            $this->call(ItemSeeder::class);
            $items = Item::all();
        }

  
        // Loop untuk setiap user (kecuali user pertama/admin)
        // Buat keranjang aktif dengan beberapa item
        foreach ($users->skip(1)->take(3) as $user) { // Skip admin, ambil 3 user
            
            // Buat keranjang aktif untuk user
            $cart = Cart::create([
                'user_id' => $user->id,
                'status' => 'active',
            ]);

            // Ambil 3-5 item random untuk dimasukkan ke keranjang
            $randomItems = $items->random(rand(3, 5));

            // Loop untuk setiap item yang dipilih
            foreach ($randomItems as $item) {
                // Buat cart item dengan quantity random 1-3
                CartItem::create([
                    'cart_id' => $cart->id,
                    'item_id' => $item->id,
                    'quantity' => rand(1, 3),
                    'price' => $item->harga, // Simpan harga saat ini
                ]);
            }
        }

        // Buat juga beberapa keranjang yang sudah di-checkout (history)
        foreach ($users->skip(1)->take(2) as $user) { // Ambil 2 user
            
            // Buat keranjang dengan status checked_out
            $cart = Cart::create([
                'user_id' => $user->id,
                'status' => 'checked_out',
                'created_at' => now()->subDays(rand(1, 30)), // Tanggal random 1-30 hari lalu
            ]);
    
            // Ambil 2-4 item random untuk cart history
            $randomItems = $items->random(rand(2, 4));

            // Loop untuk setiap item
            foreach ($randomItems as $item) {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'item_id' => $item->id,
                    'quantity' => rand(1, 2),
                    'price' => $item->harga,
                    'created_at' => $cart->created_at,
                ]);
            }
        }


    }
}
