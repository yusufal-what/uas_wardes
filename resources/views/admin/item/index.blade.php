@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="fw-bold">🍱 Manajemen Produk</h3>
  <a href="{{ route('admin.item.create') }}" class="btn btn-primary">+ Tambah Produk</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card p-3">
  <table class="table table-bordered align-middle text-center">
    <thead class="table-primary">
      <tr>
        <th>#</th>
        <th>Gambar</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Kategori</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" width="100">
          @else
            <span>Tidak ada gambar</span>
          @endif
        </td>
        <td>{{ $item->nama }}</td>
        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
        <td>{{ $item->category->name ?? '-' }}</td>
        <td>
          <a href="{{ route('admin.item.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
          <form action="{{ route('admin.item.destroy', $item->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-muted">Belum ada produk</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
