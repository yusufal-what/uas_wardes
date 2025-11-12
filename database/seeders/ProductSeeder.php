<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'nama' => 'Kopi Hitam',
                'harga' => 10000

            ],
            [
                'nama' => 'Teh Manis',
                'harga' => 8000
            ],
        ]);
    }
}