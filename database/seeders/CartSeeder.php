<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user dan product
        $user1 = DB::table('users')->where('email', 'user1@warungdesa.com')->first();
        $user2 = DB::table('users')->where('email', 'user2@warungdesa.com')->first();
        $product1 = DB::table('items')->where('nama', 'Kopi Hitam')->first();
        $product2 = DB::table('items')->where('nama', 'Teh Manis')->first();

        // Cart untuk user1
        $cart1Id = DB::table('carts')->insertGetId([
            'user_id' => $user1 ? $user1->id : null,
        ]);
        // Tambahkan produk Kopi Hitam ke cart user1
        if ($product1) {
            DB::table('cart_items')->insert([
                'cart_id' => $cart1Id,
                'item_id' => $product1->id,
                'quantity' => 2,
                'price' => $product1->harga,
            ]);
        }

        // Cart untuk user2
        $cart2Id = DB::table('carts')->insertGetId([
            'user_id' => $user2 ? $user2->id : null,
        ]);
        if ($product2) {
            DB::table('cart_items')->insert([
                'cart_id' => $cart2Id,
                'item_id' => $product2->id,
                'quantity' => 1,
                'price' => $product2->harga,
            ]);
        }
    }
}