<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Item;

class PesananController extends Controller
{
    // ✅ Menampilkan daftar pesanan
    public function index()
    {
        $pesanan = Pesanan::latest()->get();
        return view('admin.pesanan', compact('pesanan'));
    }

    // ✅ Menyimpan pesanan baru (dari pembeli)
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|integer|min:1',
            'menu' => 'required|string|max:255',
            'total' => 'required|integer|min:1',
        ]);

        $item = Item::where('nama', $request->menu)->first();

        if (!$item) {
            return back()->withErrors(['menu' => 'Menu tidak ditemukan.']);
        }

        $total_harga = $item->harga * $request->total;

        Pesanan::create([
            'nomor_meja' => $request->nomor_meja,
            'menu' => $item->nama,
            'total' => $request->total,
            'total_harga' => $total_harga,
            'status' => 'Menunggu',
        ]);

        return back()->with('success', 'Pesanan berhasil dikirim!');
    }
}
