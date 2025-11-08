@extends('layouts.admin')

@section('content')
<h3 class="fw-bold mb-3">🍱 Manajemen Produk</h3>
<div class="card p-3">
  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>#</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($produk as $p)
      <tr>
        <td>{{ $p['id'] }}</td>
        <td>{{ $p['nama'] }}</td>
        <td>Rp {{ number_format($p['harga'], 0, ',', '.') }}</td>
        <td>
          <button class="btn btn-sm btn-warning">Edit</button>
          <button class="btn btn-sm btn-danger">Hapus</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
