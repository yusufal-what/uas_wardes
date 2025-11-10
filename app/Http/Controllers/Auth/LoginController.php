<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk menangani proses login USER/CUSTOMER
 * BUKAN untuk admin - admin punya controller terpisah (AdminAuthController)
 */
class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login untuk user/customer
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm()
    {
        // Jika user sudah login, redirect ke halaman cart
        if (Auth::check()) {
            return redirect()->route('cart.index');
        }
        
        // Tampilkan halaman login
        return view('auth.login');
    }

    /**
     * Proses login user/customer
     * Menerima email dan password dari form login
     * 
     * @param Request $request - Berisi email dan password
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input dari form login
        // Email harus valid dan password minimal 6 karakter
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Coba login dengan kredensial yang diberikan
        // Parameter kedua adalah "remember me" checkbox
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate session untuk keamanan (mencegah session fixation)
            $request->session()->regenerate();

            // Login berhasil
            // Redirect ke halaman yang dituju sebelumnya (intended)
            // Atau ke halaman cart jika tidak ada halaman sebelumnya
            return redirect()->intended(route('cart.index'))
                ->with('success', 'Login berhasil! Selamat berbelanja.');
        }

        // Login gagal
        // Kembali ke halaman login dengan pesan error
        // onlyInput('email') agar email tetap terisi di form
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout user/customer
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout user dari session
        Auth::logout();

        // Invalidate session untuk keamanan
        $request->session()->invalidate();
        
        // Regenerate CSRF token untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Logout berhasil!');
    }
}
