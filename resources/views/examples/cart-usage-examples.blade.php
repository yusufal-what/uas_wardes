{{-- 
===================================================================================
    CONTOH PENGGUNAAN FITUR KERANJANG
    File: resources/views/examples/cart-usage-examples.blade.php
===================================================================================

File ini berisi contoh-contoh kode untuk mengintegrasikan fitur keranjang
ke dalam halaman-halaman yang sudah ada di aplikasi.

--}}

{{-- ========================================================================
    CONTOH 1: TOMBOL "TAMBAH KE KERANJANG" DI HALAMAN PRODUK
======================================================================== --}}

{{-- CARA 1: Menggunakan Form Biasa --}}
<div class="product-card">
    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
    <h3>{{ $item->nama }}</h3>
    <p>Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
    
    {{-- Form untuk menambah ke keranjang --}}
    <form action="{{ route('cart.add') }}" method="POST">
        @csrf
        {{-- Hidden input untuk menyimpan ID produk --}}
        <input type="hidden" name="item_id" value="{{ $item->id }}">
        
        {{-- Input untuk quantity --}}
        <input type="number" name="quantity" value="1" min="1" max="99">
        
        {{-- Tombol submit --}}
        <button type="submit" class="btn btn-primary">
            Tambah ke Keranjang
        </button>
    </form>
</div>

{{-- ========================================================================
    CONTOH 2: TOMBOL QUICK ADD (Langsung tambah tanpa input quantity)
======================================================================== --}}

<div class="product-card">
    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
    <h3>{{ $item->nama }}</h3>
    <p>Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
    
    {{-- Form dengan quantity default 1 --}}
    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->id }}">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="btn btn-sm btn-primary">
            <i class="fa fa-shopping-cart"></i> Tambah
        </button>
    </form>
</div>

{{-- ========================================================================
    CONTOH 3: BADGE CART COUNT DI NAVBAR
======================================================================== --}}

{{-- Di file layout/navbar --}}
<nav class="navbar">
    <ul class="nav-menu">
        <li>
            <a href="{{ route('cart.index') }}" class="cart-link">
                <i class="fa fa-shopping-cart"></i>
                Keranjang
                {{-- Badge untuk menampilkan jumlah item --}}
                <span id="cart-count-badge" class="badge badge-danger">0</span>
            </a>
        </li>
    </ul>
</nav>

{{-- JavaScript untuk update badge secara real-time --}}
<script>
// Function untuk mengupdate cart count
function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            // Update badge
            const badge = document.getElementById('cart-count-badge');
            if (badge) {
                badge.textContent = data.count;
                // Sembunyikan badge jika count = 0
                badge.style.display = data.count > 0 ? 'inline' : 'none';
            }
        })
        .catch(error => {
            console.error('Error mengupdate cart count:', error);
        });
}

// Jalankan saat halaman load
document.addEventListener('DOMContentLoaded', updateCartCount);

// Update setiap 30 detik (opsional)
setInterval(updateCartCount, 30000);
</script>

{{-- ========================================================================
    CONTOH 4: MENAMBAHKAN KE KERANJANG DENGAN AJAX (Tanpa Reload)
======================================================================== --}}

<div class="product-card">
    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
    <h3>{{ $item->nama }}</h3>
    <p>Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
    
    <input type="number" id="qty-{{ $item->id }}" value="1" min="1">
    <button onclick="addToCartAjax({{ $item->id }})" class="btn btn-primary">
        Tambah ke Keranjang
    </button>
</div>

<script>
function addToCartAjax(itemId) {
    // Ambil quantity dari input
    const quantity = document.getElementById('qty-' + itemId).value;
    
    // Kirim request AJAX
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            item_id: itemId,
            quantity: parseInt(quantity)
        })
    })
    .then(response => response.json())
    .then(data => {
        // Tampilkan notifikasi sukses
        alert('Item berhasil ditambahkan ke keranjang!');
        
        // Update cart count badge
        updateCartCount();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menambahkan item ke keranjang');
    });
}
</script>

{{-- Jangan lupa tambahkan meta csrf-token di layout --}}
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

{{-- ========================================================================
    CONTOH 5: MENAMPILKAN PREVIEW CART ITEMS (Mini Cart)
======================================================================== --}}

{{-- Di navbar atau sidebar --}}
<div class="mini-cart-dropdown">
    <button id="mini-cart-toggle">
        <i class="fa fa-shopping-cart"></i>
        <span id="mini-cart-count">0</span>
    </button>
    
    <div id="mini-cart-content" class="dropdown-content" style="display: none;">
        {{-- Content akan diisi via AJAX --}}
        <div id="cart-items-list"></div>
        <div class="cart-footer">
            <p>Total: <span id="cart-total">Rp 0</span></p>
            <a href="{{ route('cart.index') }}" class="btn btn-primary btn-block">
                Lihat Keranjang
            </a>
        </div>
    </div>
</div>

<script>
// Toggle mini cart dropdown
document.getElementById('mini-cart-toggle').addEventListener('click', function() {
    const content = document.getElementById('mini-cart-content');
    content.style.display = content.style.display === 'none' ? 'block' : 'none';
    
    // Load cart items jika belum ada
    if (content.style.display === 'block') {
        loadMiniCartItems();
    }
});

function loadMiniCartItems() {
    // Fetch cart items (perlu buat API endpoint baru untuk ini)
    fetch('/api/cart/items')
        .then(response => response.json())
        .then(data => {
            // Render cart items
            const list = document.getElementById('cart-items-list');
            list.innerHTML = '';
            
            data.items.forEach(item => {
                list.innerHTML += `
                    <div class="mini-cart-item">
                        <img src="${item.image}" alt="${item.name}">
                        <div>
                            <p>${item.name}</p>
                            <p>${item.quantity} x Rp ${item.price.toLocaleString()}</p>
                        </div>
                    </div>
                `;
            });
            
            // Update total
            document.getElementById('cart-total').textContent = 
                'Rp ' + data.total.toLocaleString();
        });
}
</script>

{{-- ========================================================================
    CONTOH 6: INTEGRASI DI CONTROLLER PRODUK
======================================================================== --}}

{{-- 
Di Controller (misalnya ItemController.php):

public function show($id)
{
    // Ambil data produk
    $item = Item::with('category')->findOrFail($id);
    
    // (Opsional) Cek apakah item sudah ada di keranjang user
    $inCart = false;
    $cartQuantity = 0;
    
    if (Auth::check()) {
        $cart = Cart::getActiveCart(Auth::id());
        $cartItem = $cart->cartItems()->where('item_id', $id)->first();
        
        if ($cartItem) {
            $inCart = true;
            $cartQuantity = $cartItem->quantity;
        }
    }
    
    return view('items.show', compact('item', 'inCart', 'cartQuantity'));
}
--}}

{{-- Di View (items/show.blade.php): --}}
<div class="product-detail">
    <h1>{{ $item->nama }}</h1>
    <p>Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
    
    @if($inCart)
        {{-- Jika sudah ada di keranjang --}}
        <p class="text-success">
            <i class="fa fa-check"></i> 
            Item ini sudah ada di keranjang Anda ({{ $cartQuantity }} pcs)
        </p>
        <a href="{{ route('cart.index') }}" class="btn btn-primary">
            Lihat Keranjang
        </a>
    @else
        {{-- Jika belum ada di keranjang --}}
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit" class="btn btn-primary">
                Tambah ke Keranjang
            </button>
        </form>
    @endif
</div>

{{-- ========================================================================
    CONTOH 7: NOTIFIKASI TOAST SETELAH TAMBAH KE KERANJANG
======================================================================== --}}

{{-- Di layout utama, tambahkan container untuk toast --}}
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

<script>
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} toast-notification`;
    toast.textContent = message;
    toast.style.marginBottom = '10px';
    toast.style.padding = '15px';
    toast.style.borderRadius = '5px';
    toast.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
    toast.style.animation = 'slideIn 0.3s ease-out';
    
    document.getElementById('toast-container').appendChild(toast);
    
    // Hapus setelah 3 detik
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Modifikasi function addToCartAjax untuk menampilkan toast
function addToCartAjax(itemId) {
    const quantity = document.getElementById('qty-' + itemId).value;
    
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            item_id: itemId,
            quantity: parseInt(quantity)
        })
    })
    .then(response => response.json())
    .then(data => {
        // Tampilkan toast notification
        showToast('Item berhasil ditambahkan ke keranjang!', 'success');
        updateCartCount();
    })
    .catch(error => {
        showToast('Gagal menambahkan item ke keranjang', 'danger');
    });
}

// CSS Animation (tambahkan di CSS file)
/*
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
*/
</script>

{{-- ========================================================================
    CONTOH 8: VALIDASI STOK SEBELUM TAMBAH KE KERANJANG
======================================================================== --}}

{{-- 
Tambahkan kolom 'stok' di tabel items jika belum ada:
Migration:
$table->integer('stok')->default(0);
--}}

{{-- Di View: --}}
<div class="product-detail">
    <h1>{{ $item->nama }}</h1>
    <p>Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
    <p>Stok: {{ $item->stok }} pcs</p>
    
    @if($item->stok > 0)
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <input type="number" 
                   name="quantity" 
                   value="1" 
                   min="1" 
                   max="{{ $item->stok }}"
                   required>
            <button type="submit" class="btn btn-primary">
                Tambah ke Keranjang
            </button>
        </form>
    @else
        <p class="text-danger">Stok habis</p>
        <button class="btn btn-secondary" disabled>Stok Habis</button>
    @endif
</div>

{{-- ========================================================================
    TIPS DAN BEST PRACTICES
======================================================================== --}}

{{-- 
1. SELALU GUNAKAN CSRF TOKEN
   - Semua form POST harus ada @csrf
   - AJAX request harus include X-CSRF-TOKEN header

2. VALIDASI DI SISI CLIENT DAN SERVER
   - Client-side: validasi quantity min/max
   - Server-side: validasi di controller

3. GUNAKAN DATABASE TRANSACTION
   - Sudah diimplementasi di CartController
   - Pastikan data consistency

4. HANDLE ERROR DENGAN BAIK
   - Tampilkan pesan error yang jelas ke user
   - Log error untuk debugging

5. OPTIMIZE QUERY
   - Gunakan eager loading untuk relasi
   - Hindari N+1 query problem

6. USER EXPERIENCE
   - Berikan feedback visual saat tambah ke keranjang
   - Update cart count secara real-time
   - Loading indicator untuk operasi AJAX

7. SECURITY
   - Selalu validasi kepemilikan cart/cart item
   - Sanitize input
   - Gunakan middleware auth

8. TESTING
   - Test semua fitur keranjang
   - Test edge cases (stok habis, item dihapus, dll)
--}}

{{-- ========================================================================
    TROUBLESHOOTING COMMON ISSUES
======================================================================== --}}

{{-- 
ISSUE 1: "Call to a member function cartItems() on null"
SOLUSI: Pastikan user sudah login dan cart sudah dibuat

ISSUE 2: "CSRF token mismatch"
SOLUSI: 
- Tambahkan @csrf di form
- Atau tambahkan meta tag csrf dan include di AJAX header

ISSUE 3: "Badge count tidak update"
SOLUSI: Pastikan route 'cart.count' sudah terdaftar dan accessible

ISSUE 4: "Item tidak bertambah di keranjang"
SOLUSI: 
- Cek validasi input
- Cek apakah item_id exist di database
- Lihat error log di storage/logs/laravel.log
--}}
