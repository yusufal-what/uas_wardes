<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk membuat tabel cart_items (item dalam keranjang belanja)
 * Tabel ini menyimpan detail produk yang ada di dalam keranjang
 */
return new class extends Migration
{
    /**
     * Menjalankan migration untuk membuat tabel cart_items
     * Method ini akan dieksekusi saat menjalankan php artisan migrate
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            // ID primary key auto increment
            $table->id();
            
            // Foreign key ke tabel carts - menghubungkan item dengan keranjang
            $table->unsignedBigInteger('cart_id');
            
            // Foreign key ke tabel items - menghubungkan dengan produk yang dibeli
            $table->unsignedBigInteger('item_id');
            
            // Jumlah produk yang dibeli
            // Default 1 karena minimal pembelian adalah 1 item
            // unsigned() memastikan nilainya tidak negatif
            $table->integer('quantity')->unsigned()->default(1);
            
            // Harga satuan produk saat ditambahkan ke keranjang
            // Disimpan untuk menjaga konsistensi jika harga produk berubah
            $table->decimal('price', 10, 2);
            
            // Timestamps untuk created_at dan updated_at
            $table->timestamps();
            
            // Membuat foreign key constraint untuk cart_id
            // Jika keranjang dihapus, semua item di dalamnya juga dihapus (cascade)
            $table->foreign('cart_id')
                  ->references('id')
                  ->on('carts')
                  ->onDelete('cascade');
            
            // Membuat foreign key constraint untuk item_id
            // Jika produk dihapus, item di keranjang juga dihapus (cascade)
            $table->foreign('item_id')
                  ->references('id')
                  ->on('items')
                  ->onDelete('cascade');
            
            // Unique constraint untuk memastikan tidak ada duplikasi item dalam satu keranjang
            // Satu produk hanya boleh ada sekali dalam satu keranjang
            // Jika ingin menambah, cukup update quantity-nya
            $table->unique(['cart_id', 'item_id']);
            
            // Index untuk mempercepat pencarian berdasarkan cart_id
            $table->index('cart_id');
        });
    }

    /**
     * Membatalkan migration dengan menghapus tabel cart_items
     * Method ini akan dieksekusi saat menjalankan php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
