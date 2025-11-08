<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Simulasi data
        $totalPesanan = 12;
        $totalProduk = 8;
        $totalPendapatan = 1200000;

        return view('admin.dashboard', compact('totalPesanan', 'totalProduk', 'totalPendapatan'));
    }

    public function produk()
    {
        $produk = [
            ['id' => 1, 'nama' => 'Nasi Goreng Spesial', 'harga' => 15000],
            ['id' => 2, 'nama' => 'Ayam Geprek', 'harga' => 13000],
            ['id' => 3, 'nama' => 'Es Teh Manis', 'harga' => 5000],
        ];
        return view('admin.produk', compact('produk'));
    }

    public function pesanan()
    {
        $pesanan = [
            ['id' => 1, 'nomor_meja' => 5, 'menu' => 'Nasi Goreng Spesial', 'total' => 15000, 'status' => 'Selesai'],
            ['id' => 2, 'nomor_meja' => 7, 'menu' => 'Ayam Geprek', 'total' => 13000, 'status' => 'Proses'],
        ];
        return view('admin.pesanan', compact('pesanan'));
    }

    public function log()
    {
        $log = [
            ['waktu' => '2025-11-02 12:30', 'aksi' => 'Admin login ke sistem'],
            ['waktu' => '2025-11-02 12:45', 'aksi' => 'Menambahkan produk baru: Ayam Geprek'],
            ['waktu' => '2025-11-02 13:00', 'aksi' => 'Mengonfirmasi pesanan meja 7'],
        ];
        return view('admin.log', compact('log'));
    }
}
