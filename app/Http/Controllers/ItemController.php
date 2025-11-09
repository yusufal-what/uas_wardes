<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $produk = Item::latest()->get();
        return view('admin.item.index', compact('produk'));
    }

    // Form tambah produk
    public function create()
    {
        return view('admin.item.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'kategori' => 'required|in:makanan,minuman',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke storage/app/public/items
            $path = $request->file('gambar')->store('items', 'public');
        }

        Item::create([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'kategori' => $validated['kategori'],
            'gambar' => $path,
        ]);

        return redirect()->route('admin.item.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit produk
    public function edit(Item $item)
    {
        return view('admin.item.edit', compact('item'));
    }

    // Update produk
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'kategori' => 'required|in:makanan,minuman',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $gambarPath = $item->gambar;

        // Hapus gambar lama jika ada dan upload baru
        if ($request->hasFile('gambar')) {
            if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('gambar')->store('items', 'public');
        }

        $item->update([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'kategori' => $validated['kategori'],
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.item.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus produk
    public function destroy(Item $item)
    {
        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return redirect()->route('admin.item.index')->with('success', 'Produk berhasil dihapus!');
    }
}
