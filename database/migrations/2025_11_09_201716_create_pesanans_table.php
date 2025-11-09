<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel 'pesanans'
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_meja');
            $table->string('menu');
            $table->integer('total');
            $table->integer('total_harga');
            $table->string('status')->default('Menunggu');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Undo migration: hapus tabel 'pesanans'
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
