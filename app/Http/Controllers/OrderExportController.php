<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class OrderExportController extends Controller
{
    public function export()
    {
        $orders = Pesanan::all();

        $filename = "orders.csv";

        // header CSV
        $csvData = "Order ID,Nama Pelanggan,Nomor Telepon,Meja,Total,Status,Waktu\n";

        // isi data
        foreach ($orders as $order) {
            $csvData .= $order->id . ",";
            $csvData .= ($order->customer_name ?? '-') . ",";
            $csvData .= ($order->customer_phone ?? '-') . ",";
            $csvData .= ($order->table_id ?? '-') . ",";
            $csvData .= $order->total . ",";
            $csvData .= $order->status . ",";
            $csvData .= $order->created_at . "\n";
        }

        // download CSV
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}