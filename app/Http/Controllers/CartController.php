<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'status' => 'active'
            ]);
        }

        $cartItems = $cart->cartItems()->with('item')->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart.index', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active'],
            ['user_id' => Auth::id()]
        );

        $item = Item::findOrFail($request->item_id);

        $cartItem = $cart->cartItems()->where('item_id', $request->item_id)->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity
            ]);
        } else {
            $cart->cartItems()->create([
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'price' => $item->harga
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Quantity updated successfully!');
    }

    public function removeItem(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        // Mark cart as completed
        $cart->update(['status' => 'completed']);

        // Create a new empty cart for the user
        Cart::create([
            'user_id' => Auth::id(),
            'status' => 'active'
        ]);

        return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
    }
}