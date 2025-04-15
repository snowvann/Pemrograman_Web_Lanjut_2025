@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Detail Data Stok</h3>
        <div class="card-tools">
            <a href="{{ url('penjualan') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Stok ID</th>
                <td>{{ $stok->stok_id }}</td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <td>{{ $stok->barang->nama_barang ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama User</th>
                <td>{{ $stok->user->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jumlah Stok</th>
                <td>{{ $stok->jumlah }}</td>
            </tr>
            <tr>
                <th>Tanggal Input</th>
                <td>{{ $stok->created_at->format('d M Y, H:i') }}</td>
            </tr>
            <tr>
                <th>Terakhir Diubah</th>
                <td>{{ $stok->updated_at->format('d M Y, H:i') }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
