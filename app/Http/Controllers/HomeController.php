<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page) dengan fitur pencarian menu
     */
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari input (jika ada)
        $query = $request->input('search');

        // Jika ada pencarian, filter berdasarkan nama (case-insensitive)
        if ($query) {
            $items = Item::whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($query) . '%'])->get();
        } else {
            // Jika tidak ada pencarian, tampilkan semua produk
            $items = Item::all();
        }

        // Kirim data ke view welcome.blade.php
        return view('welcome', compact('items', 'query'));
    }
}
