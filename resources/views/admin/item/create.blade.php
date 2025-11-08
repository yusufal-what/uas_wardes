@extends('layouts.admin')

@section('content')
<h3 class="fw-bold mb-3">➕ Tambah Produk Baru</h3>

<div class="card p-4">
  <form action="{{ route('admin.item.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label class="form-label">Nama Produk</label>
      <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="harga" class="form-control" required>
    </div>
    <div class="form-group">
    <label for="category_id">Kategori</label>
    <select name="category_id" id="category_id" class="form-control">
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

    <div class="mb-3">
      <label class="form-label">Gambar Produk</label>
      <input type="file" name="gambar" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('admin.item.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
