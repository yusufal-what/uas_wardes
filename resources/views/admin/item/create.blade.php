@extends('layouts.admin')

@section('content')
<h3 class="fw-bold mb-3">➕ Tambah Produk Baru</h3>

<div class="card p-4">
  
  {{-- 🔴 Tampilkan pesan error validasi --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

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

    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="kategori" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="Makanan">Makanan</option>
        <option value="Minuman">Minuman</option>
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
