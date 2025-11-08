<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        // Ambil semua item beserta relasi kategori
        $items = Item::with('category')->latest()->get();
        return view('admin.item.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.item.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('items', 'public');
        }

        Item::create([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'gambar' => $path,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.item.index')->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('admin.item.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $gambarPath = $item->gambar;

        if ($request->hasFile('gambar')) {
            if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('gambar')->store('items', 'public');
        }

        $item->update([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'gambar' => $gambarPath,
            'category_id' => $request->category_id ?? $item->category_id,
        ]);

        return redirect()->route('admin.item.index')->with('success', 'Item berhasil diperbarui!');
    }

    public function destroy(Item $item)
    {
        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();
        return redirect()->route('admin.item.index')->with('success', 'Item berhasil dihapus!');
    }
}
