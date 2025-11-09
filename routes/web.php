<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ItemController;

// ============================
// 🏠 Halaman Utama (Landing Page)
// ============================
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🔘 Pembeli kirim pesanan
Route::post('/pesan', [PesananController::class, 'store'])->name('pesanan.store');

// ============================
// 🔐 Area Admin (dengan middleware auth + verified)
// ============================
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Menu (Item)
    Route::resource('item', ItemController::class, ['as' => 'admin']);

    // Daftar Pesanan Masuk
    Route::get('/pesanan', [PesananController::class, 'index'])->name('admin.pesanan');
});

// ============================
// 👤 Profile User
// ============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================
// 🔑 Auth Routes (Login, Register, dll)
// ============================
require __DIR__ . '/auth.php';
