{{-- 
    View: Halaman Success Checkout
    File: resources/views/cart/success.blade.php
    Deskripsi: Halaman konfirmasi setelah checkout berhasil
--}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        {{-- Card Success --}}
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            
            {{-- Icon Success (menggunakan SVG) --}}
            <div class="flex justify-center mb-6">
                <svg class="w-20 h-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            {{-- Judul --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Checkout Berhasil!
            </h1>

            {{-- Pesan --}}
            <p class="text-gray-600 mb-6">
                Terima kasih atas pembelian Anda. Pesanan Anda sedang diproses.
            </p>

            {{-- Info Tambahan --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-700">
                    Kami akan mengirimkan konfirmasi pesanan ke email Anda.
                    Silakan cek email untuk detail pesanan dan informasi pengiriman.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                {{-- Tombol Lihat Pesanan (jika ada fitur order history) --}}
                {{-- <a href="{{ route('orders.index') }}" 
                   class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600">
                    Lihat Pesanan Saya
                </a> --}}

                {{-- Tombol Kembali ke Beranda --}}
                <a href="{{ url('/') }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600">
                    Kembali ke Beranda
                </a>

                {{-- Tombol Lanjut Belanja --}}
                <a href="{{ url('/') }}" 
                   class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600">
                    Lanjut Belanja
                </a>
            </div>
        </div>

        {{-- Timeline Proses (Opsional) --}}
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Proses Selanjutnya</h2>
            <div class="space-y-4">
                {{-- Step 1 --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center">
                        ✓
                    </div>
                    <div>
                        <h3 class="font-semibold">Pesanan Diterima</h3>
                        <p class="text-sm text-gray-600">Pesanan Anda telah kami terima dan sedang diproses</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center">
                        2
                    </div>
                    <div>
                        <h3 class="font-semibold">Konfirmasi Pembayaran</h3>
                        <p class="text-sm text-gray-600">Kami akan mengirimkan detail pembayaran ke email Anda</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center">
                        3
                    </div>
                    <div>
                        <h3 class="font-semibold">Pengiriman</h3>
                        <p class="text-sm text-gray-600">Pesanan akan dikirim setelah pembayaran dikonfirmasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
