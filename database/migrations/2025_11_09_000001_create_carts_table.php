<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk membuat tabel carts (keranjang belanja)
 * Tabel ini menyimpan informasi keranjang belanja untuk setiap user
 */
return new class extends Migration
{
    /**
     * Menjalankan migration untuk membuat tabel carts
     * Method ini akan dieksekusi saat menjalankan php artisan migrate
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            // ID primary key auto increment
            $table->id();
            
            // Foreign key ke tabel users - menghubungkan keranjang dengan user
            // unsignedBigInteger digunakan karena id di tabel users bertipe bigint
            $table->unsignedBigInteger('user_id');
            
            // Status keranjang: 'active' untuk keranjang yang sedang digunakan
            // 'checked_out' untuk keranjang yang sudah di-checkout
            // Default 'active' karena keranjang baru dibuat pasti masih aktif
            $table->enum('status', ['active', 'checked_out'])->default('active');
            
            // Timestamps untuk created_at dan updated_at
            // Laravel otomatis mengisi kolom ini
            $table->timestamps();
            
            // Membuat foreign key constraint
            // Jika user dihapus, maka keranjangnya juga akan dihapus (cascade)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Index untuk mempercepat pencarian berdasarkan user_id dan status
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Membatalkan migration dengan menghapus tabel carts
     * Method ini akan dieksekusi saat menjalankan php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
