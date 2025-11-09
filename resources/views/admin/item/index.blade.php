@extends('layouts.admin')

@section('content')
<h3 class="fw-bold mb-3">🍱 Manajemen Produk</h3>

{{-- Notifikasi sukses --}}
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Tombol tambah produk --}}
<div class="d-flex justify-content-end mb-3">
  <a href="{{ route('admin.item.create') }}" class="btn btn-success">+ Tambah Produk</a>
</div>

{{-- Tabel produk --}}
<div class="card p-3">
  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>#</th>
        <th>Gambar</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($produk as $p)
      <tr>
        <td>{{ $p->id }}</td>

        {{-- ✅ Langkah 3: tampilkan gambar dari folder storage --}}
        <td>
          @if ($p->gambar && file_exists(public_path('storage/' . $p->gambar)))
            <img src="{{ asset('storage/' . $p->gambar) }}" width="70" height="70" class="rounded shadow-sm object-fit-cover">
          @else
            <span class="text-muted fst-italic">Tidak ada gambar</span>
          @endif
        </td>

        <td>{{ $p->nama }}</td>
        <td>{{ ucfirst($p->kategori) }}</td>
        <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>

        <td>
          <a href="{{ route('admin.item.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('admin.item.destroy', $p->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="text-center text-muted">Belum ada produk.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
