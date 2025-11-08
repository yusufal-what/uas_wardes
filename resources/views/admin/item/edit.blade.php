@extends('layouts.admin')

@section('content')
<h3 class="fw-bold mb-3">✏️ Edit Item</h3>

<div class="card p-4">
  <form action="{{ route('admin.item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Nama Item</label>
      <input type="text" name="nama" value="{{ $item->nama }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="harga" value="{{ $item->harga }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="category_id" class="form-select" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" 
            {{ $item->category_id == $category->id ? 'selected' : '' }}>
            {{ $category->nama ?? $category->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Gambar Item</label><br>
      @if($item->gambar)
        <img src="{{ asset('storage/' . $item->gambar) }}" width="150" class="mb-2" alt="{{ $item->nama }}">
      @endif
      <input type="file" name="gambar" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.item.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
