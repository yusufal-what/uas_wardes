@extends('layouts.admin')

@section('content')
<h3 class="fw-bold mb-3">🧾 Daftar Pesanan Masuk</h3>
<div class="card p-3">
  <table class="table table-bordered text-center">
    <thead class="table-primary">
      <tr>
        <th>#</th>
        <th>Nomor Meja</th>
        <th>Menu</th>
        <th>Total</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pesanan as $p)
      <tr>
        <td>{{ $p['id'] }}</td>
        <td>Meja {{ $p['nomor_meja'] }}</td>
        <td>{{ $p['menu'] }}</td>
        <td>Rp {{ number_format($p['total'], 0, ',', '.') }}</td>
        <td>
          <span class="badge {{ $p['status'] == 'Selesai' ? 'bg-success' : 'bg-warning' }}">{{ $p['status'] }}</span>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
