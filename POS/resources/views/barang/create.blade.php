@extends('layouts.app')

@section('content')
<h2>Tambah Barang</h2>
<form action="{{ route('barang.store') }}" method="POST">
    @csrf
    Kode: <input type="text" name="barang_kode"><br>
    Nama: <input type="text" name="barang_nama"><br>
    Harga Beli: <input type="number" name="harga_beli"><br>
    Harga Jual: <input type="number" name="harga_jual"><br>
    <button type="submit">Simpan</button>
</form>
@endsection
