<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('admin.pesanan');
    // CRUD Produk
   Route::resource('item', ItemController::class)->names('admin.item');

});

// Semua route cart memerlukan autentikasi user
Route::middleware('auth')->prefix('cart')->name('cart.')->group(function () {
    
    // GET /cart - Menampilkan halaman keranjang belanja
    Route::get('/', [CartController::class, 'index'])->name('index');
    
    // POST /cart/add - Menambahkan item ke keranjang
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    
    // PUT /cart/update/{cartItemId} - Update quantity item di keranjang
    Route::put('/update/{cartItemId}', [CartController::class, 'updateQuantity'])->name('update');
    
    // DELETE /cart/remove/{cartItemId} - Menghapus item dari keranjang
    Route::delete('/remove/{cartItemId}', [CartController::class, 'removeItem'])->name('remove');
    
    // POST /cart/clear - Mengosongkan seluruh keranjang
    Route::post('/clear', [CartController::class, 'clearCart'])->name('clear');
    
    // POST /cart/checkout - Proses checkout
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    
    // GET /cart/success - Halaman sukses setelah checkout
    Route::get('/success', [CartController::class, 'success'])->name('success');
    
    // GET /cart/count - Mendapatkan jumlah item di keranjang (untuk AJAX)
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});
