@extends('layouts.admin')

@section('content')
<h3 class="fw-bold mb-3">✏️ Edit Produk</h3>

<div class="card p-4">
  <form action="{{ route('admin.item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Nama Produk</label>
      <input type="text" name="nama" value="{{ $item->nama }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="harga" value="{{ $item->harga }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="kategori" class="form-control" required>
        <option value="makanan" {{ $item->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
        <option value="minuman" {{ $item->kategori == 'minuman' ? 'selected' : '' }}>Minuman</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Gambar Produk</label><br>
      @if ($item->gambar)
        <img src="{{ asset('storage/' . $item->gambar) }}" width="80" class="mb-2 rounded">
      @endif
      <input type="file" name="gambar" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.item.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
