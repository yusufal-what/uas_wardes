<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu - Warung Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Poppins', sans-serif;
        }
        .meja-header {
            background: white;
            padding: 15px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .menu-card {
            border: none;
            transition: all 0.3s ease-in-out;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 100%;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .menu-card img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 180px;
            object-fit: cover;
            width: 100%;
        }
        .btn-add-cart {
            background-color: #198754;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-add-cart:hover {
            background-color: #146c43;
        }
        .cart-badge {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="meja-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-success">Menu Warung Desa</h5>
            </div>
        </div>
    </div>

    <div class="container my-4">

        <!-- 🔍 Fitur Search Menu -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari menu...">
        </div>

        <!-- 🔘 Tombol Kategori -->
        <ul class="nav nav-pills mb-4" id="menuTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-category="semua" type="button">Semua</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-category="makanan" type="button">Makanan</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-category="minuman" type="button">Minuman</button>
            </li>
        </ul>

        <!-- 📋 Daftar Menu -->
        <div class="row g-4" id="menuList">
            @forelse($items as $item)
                <div class="col-md-3 col-sm-6 menu-item" 
                     data-name="{{ strtolower($item->nama) }}" 
                     data-category="{{ strtolower($item->kategori) }}">
                    <div class="card menu-card">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:180px;border-top-left-radius:15px;border-top-right-radius:15px;">
                                <span class="text-white">No Image</span>
                            </div>
                        @endif
                        <div class="card-body text-center">
                            <h5 class="fw-semibold mb-2">{{ $item->nama }}</h5>
                            <p class="text-muted mb-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            <span class="badge bg-success mb-3">{{ ucfirst($item->kategori) }}</span>
                            <button onclick="addToCart({{ $item->id }}, '{{ $item->nama }}', {{ $item->harga }})"
                                class="btn btn-add-cart w-100">
                                <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Tidak ada menu ditemukan.</p>
            @endforelse
        </div>
    </div>

    <!-- 🛒 Tombol Keranjang -->
    <div class="cart-badge">
        <button onclick="viewCart()" class="btn btn-success shadow-lg position-relative">
            <i class="bi bi-cart3 fs-5"></i>
            <span id="cart-count" class="cart-count">0</span>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const menuItems = document.querySelectorAll('.menu-item');
        const categoryButtons = document.querySelectorAll('[data-category]');
        let activeCategory = 'semua';

        // 🔍 Fungsi Pencarian + Filter Kategori
        function filterMenu() {
            const searchValue = searchInput.value.trim().toLowerCase();

            menuItems.forEach(item => {
                const name = (item.getAttribute('data-name') || '').toLowerCase();
                const category = (item.getAttribute('data-category') || '').toLowerCase();

                const matchesSearch = name.includes(searchValue);
                const matchesCategory = activeCategory === 'semua' || category === activeCategory;

                item.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
            });
        }

        // Event pencarian real-time
        searchInput.addEventListener('input', filterMenu);

        // Event klik kategori
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                activeCategory = this.getAttribute('data-category');
                filterMenu();
            });
        });

        // 🛒 Fungsi Keranjang (tidak diubah)
        const TOKEN = '{{ $token ?? "" }}';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

        function getCart() {
            const cart = localStorage.getItem('cart_' + TOKEN);
            return cart ? JSON.parse(cart) : [];
        }
        function saveCart(cart) {
            localStorage.setItem('cart_' + TOKEN, JSON.stringify(cart));
            updateCartCount();
        }
        function addToCart(id, nama, harga) {
            if (event) event.stopPropagation();
            let cart = getCart();
            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ id, name: nama, price: harga, quantity: 1 });
            }
            saveCart(cart);
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: nama + ' ditambahkan ke keranjang',
                timer: 1200,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }
        function updateCartCount() {
            const cart = getCart();
            const total = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = total;
        }
        updateCartCount();
    </script>
</body>
</html>
