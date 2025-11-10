<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * CartController
 * Controller untuk mengelola keranjang belanja user
 * Menangani operasi CRUD (Create, Read, Update, Delete) untuk keranjang
 */
class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja
     * Route: GET /cart
     */
    public function index()
    {
        // Mengambil ID user yang sedang login
        $userId = Auth::id();
        
        // Mendapatkan keranjang aktif user
        $cart = Cart::getActiveCart($userId);
        
        // Eager loading: mengambil data cartItems beserta relasi item dan category
        // Ini untuk menghindari N+1 query problem (query berulang)
        $cart->load(['cartItems.item.category']);
        
        // Menghitung total harga dan total quantity
        $totalPrice = $cart->getTotalPrice();
        $totalQuantity = $cart->getTotalQuantity();
        
        // Mengembalikan view dengan data keranjang
        return view('cart.index', compact('cart', 'totalPrice', 'totalQuantity'));
    }

    /**
     * Menambahkan item ke keranjang
     * Route: POST /cart/add
     */
    public function addToCart(Request $request)
    {
        // Validasi input dari request
        // item_id harus ada, integer, dan exist di tabel items
        // quantity harus integer dan minimal 1
        $validated = $request->validate([
            'item_id' => 'required|integer|exists:items,id',
            'quantity' => 'integer|min:1',
        ]);

        // Menggunakan database transaction untuk memastikan konsistensi data
        // Jika terjadi error, semua perubahan akan di-rollback
        DB::beginTransaction();
        
        try {
            // Mendapatkan ID user yang sedang login
            $userId = Auth::id();
            
            // Mendapatkan atau membuat keranjang aktif user
            $cart = Cart::getActiveCart($userId);
            
            // Mengambil data item/produk dari database
            $item = Item::findOrFail($validated['item_id']);
            
            // Mengambil quantity dari request, default 1 jika tidak ada
            $quantity = $validated['quantity'] ?? 1;
            
            // Cek apakah item sudah ada di keranjang
            $cartItem = CartItem::where('cart_id', $cart->id)
                               ->where('item_id', $item->id)
                               ->first();
            
            if ($cartItem) {
                // Jika item sudah ada, tambahkan quantity-nya
                $cartItem->incrementQuantity($quantity);
                $message = 'Jumlah item berhasil diperbarui di keranjang';
            } else {
                // Jika item belum ada, buat cart item baru
                CartItem::create([
                    'cart_id' => $cart->id,
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                    'price' => $item->harga, // Simpan harga saat ini
                ]);
                $message = 'Item berhasil ditambahkan ke keranjang';
            }
            
            // Commit transaction jika semua berhasil
            DB::commit();
            
            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            
            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Gagal menambahkan item ke keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Update quantity item di keranjang
     * Route: PUT /cart/update/{cartItemId}
     */
    public function updateQuantity(Request $request, int $cartItemId)
    {
        // Validasi input quantity
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            // Mendapatkan ID user yang sedang login
            $userId = Auth::id();
            
            // Mengambil cart item dengan validasi kepemilikan
            // whereHas untuk memastikan cart item ini milik user yang login
            $cartItem = CartItem::whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('status', 'active');
            })->findOrFail($cartItemId);
            
            // Update quantity
            $cartItem->updateQuantity($validated['quantity']);
            
            DB::commit();
            
            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Quantity berhasil diperbarui');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Gagal memperbarui quantity: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus item dari keranjang
     * Route: DELETE /cart/remove/{cartItemId}
     */
    public function removeItem(int $cartItemId)
    {
        DB::beginTransaction();
        
        try {
            // Mendapatkan ID user yang sedang login
            $userId = Auth::id();
            
            // Mengambil cart item dengan validasi kepemilikan
            $cartItem = CartItem::whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('status', 'active');
            })->findOrFail($cartItemId);
            
            // Hapus cart item
            $cartItem->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Gagal menghapus item: ' . $e->getMessage());
        }
    }

    /**
     * Mengosongkan seluruh keranjang
     * Route: POST /cart/clear
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCart()
    {
        DB::beginTransaction();
        
        try {
            // Mendapatkan ID user yang sedang login
            $userId = Auth::id();
            
            // Mendapatkan keranjang aktif user
            $cart = Cart::getActiveCart($userId);
            
            // Mengosongkan keranjang
            $cart->clearCart();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Gagal mengosongkan keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Proses checkout keranjang
     * Route: POST /cart/checkout
     */
    public function checkout()
    {
        DB::beginTransaction();
        
        try {
            // Mendapatkan ID user yang sedang login
            $userId = Auth::id();
            
            // Mendapatkan keranjang aktif user
            $cart = Cart::getActiveCart($userId);
            
            // Validasi: keranjang tidak boleh kosong
            if ($cart->cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Keranjang Anda kosong');
            }
            
            // Load relasi untuk mendapatkan detail items
            $cart->load('cartItems.item');
            
            // Validasi stok produk (opsional, jika ada kolom stok)
            // foreach ($cart->cartItems as $cartItem) {
            //     if ($cartItem->item->stok < $cartItem->quantity) {
            //         return redirect()->back()->with('error', 'Stok ' . $cartItem->item->nama . ' tidak mencukupi');
            //     }
            // }
            
            // Ubah status keranjang menjadi checked_out
            $cart->checkout();
            

            DB::commit();
            
            return redirect()->route('cart.success')->with('success', 'Checkout berhasil! Terima kasih atas pembelian Anda');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Gagal melakukan checkout: ' . $e->getMessage());
        }
    }

    /**
     * Halaman sukses setelah checkout
     * Route: GET /cart/success
     * 
     * @return \Illuminate\View\View
     */
    public function success()
    {
        // Menampilkan halaman sukses checkout
        return view('cart.success');
    }

    /**
     * Mendapatkan jumlah item di keranjang (untuk badge/counter)
     * Route: GET /cart/count
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCartCount()
    {
        try {
            // Mendapatkan ID user yang sedang login
            $userId = Auth::id();
            
            // Jika user tidak login, return 0
            if (!$userId) {
                return response()->json(['count' => 0]);
            }
            
            // Mendapatkan keranjang aktif user
            $cart = Cart::getActiveCart($userId);
            
            // Menghitung total quantity
            $count = $cart->getTotalQuantity();
            
            return response()->json(['count' => $count]);
            
        } catch (\Exception $e) {
            return response()->json(['count' => 0, 'error' => $e->getMessage()]);
        }
    }
}
