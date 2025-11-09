<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
    $totalPesanan = \App\Models\Pesanan::count();
    $totalProduk = \App\Models\Item::count(); // pakai Item, bukan Produk
    $totalPendapatan = \App\Models\Pesanan::sum('total_harga');

    return view('admin.dashboard', compact('totalPesanan', 'totalProduk', 'totalPendapatan'));
}


}
