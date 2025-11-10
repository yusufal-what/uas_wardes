<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller untuk menangani proses registrasi USER/CUSTOMER baru
 */
class RegisterController extends Controller
{
    /**
     * Menampilkan halaman form registrasi
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showRegistrationForm()
    {
        // Jika user sudah login, redirect ke cart
        if (Auth::check()) {
            return redirect()->route('cart.index');
        }
        
        // Tampilkan halaman registrasi
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru
     * Menerima nama, email, password, dan konfirmasi password
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Nama wajib diisi
            'email' => 'required|string|email|max:255|unique:users', // Email harus unik
            'password' => 'required|string|min:6|confirmed', // Password minimal 6 karakter dan harus match dengan password_confirmation
        ]);

        // Buat user baru di database
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hash password untuk keamanan
        ]);

        // Login otomatis setelah registrasi berhasil
        Auth::login($user);

        // Redirect ke halaman cart dengan pesan sukses
        return redirect()->route('cart.index')
            ->with('success', 'Registrasi berhasil! Selamat berbelanja.');
    }
}
