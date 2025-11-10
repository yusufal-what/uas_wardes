{{-- 
    View: Halaman Keranjang Belanja
    File: resources/views/cart/index.blade.php
    Deskripsi: Menampilkan daftar item yang ada di keranjang belanja user
--}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Judul Halaman --}}
    <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>

    {{-- Alert untuk menampilkan pesan sukses atau error --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Cek apakah keranjang kosong --}}
    @if($cart->cartItems->isEmpty())
        {{-- Tampilan jika keranjang kosong --}}
        <div class="bg-gray-100 p-8 text-center rounded-lg">
            <p class="text-gray-600 text-lg mb-4">Keranjang Anda kosong</p>
            <a href="{{ url('/') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Mulai Belanja
            </a>
        </div>
    @else
        {{-- Tampilan jika ada item di keranjang --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Kolom kiri: Daftar Item --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    {{-- Loop melalui setiap cart item --}}
                    @foreach($cart->cartItems as $cartItem)
                        <div class="p-4 border-b last:border-b-0 flex items-center gap-4">
                            
                            {{-- Gambar Produk --}}
                            <div class="w-24 h-24 flex-shrink-0">
                                @if($cartItem->item->gambar)
                                    <img src="{{ asset('storage/' . $cartItem->item->gambar) }}" 
                                         alt="{{ $cartItem->item->nama }}"
                                         class="w-full h-full object-cover rounded">
                                @else
                                    <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Detail Produk --}}
                            <div class="flex-grow">
                                <h3 class="font-semibold text-lg">{{ $cartItem->item->nama }}</h3>
                                <p class="text-gray-600">Kategori: {{ $cartItem->item->category->nama ?? '-' }}</p>
                                <p class="text-blue-600 font-semibold mt-1">
                                    Rp {{ number_format($cartItem->price, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Quantity Controls --}}
                            <div class="flex items-center gap-2">
                                {{-- Form untuk update quantity --}}
                                <form action="{{ route('cart.update', $cartItem->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    
                                    {{-- Input quantity --}}
                                    <input type="number" 
                                           name="quantity" 
                                           value="{{ $cartItem->quantity }}" 
                                           min="1" 
                                           class="w-16 border rounded px-2 py-1 text-center">
                                    
                                    {{-- Tombol Update --}}
                                    <button type="submit" 
                                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Update
                                    </button>
                                </form>

                                {{-- Form untuk hapus item --}}
                                <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('Yakin ingin menghapus item ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-right">
                                <p class="font-semibold">
                                    Rp {{ number_format($cartItem->getSubtotal(), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tombol Kosongkan Keranjang --}}
                <div class="mt-4">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            {{-- Kolom kanan: Ringkasan Pesanan --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Ringkasan Pesanan</h2>
                    
                    {{-- Total Item --}}
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Total Item:</span>
                        <span class="font-semibold">{{ $totalQuantity }}</span>
                    </div>

                    {{-- Total Harga --}}
                    <div class="flex justify-between mb-4 text-lg">
                        <span class="font-semibold">Total Harga:</span>
                        <span class="font-bold text-blue-600">
                            Rp {{ number_format($totalPrice, 0, ',', '.') }}
                        </span>
                    </div>

                    <hr class="my-4">

                    {{-- Tombol Checkout --}}
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-green-500 text-white py-3 rounded-lg font-semibold hover:bg-green-600">
                            Checkout
                        </button>
                    </form>

                    {{-- Link Lanjut Belanja --}}
                    <a href="{{ url('/') }}" 
                       class="block text-center mt-3 text-blue-500 hover:underline">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

{{-- 
    JavaScript untuk update cart count secara real-time (opsional)
    Bisa diletakkan di section scripts jika layout mendukung
--}}
@push('scripts')
<script>
// Function untuk update badge cart count di navbar
function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            // Update badge dengan jumlah item
            const badge = document.getElementById('cart-count-badge');
            if (badge) {
                badge.textContent = data.count;
                badge.style.display = data.count > 0 ? 'inline' : 'none';
            }
        })
        .catch(error => console.error('Error:', error));
}

// Panggil function saat halaman load
document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
@endpush
