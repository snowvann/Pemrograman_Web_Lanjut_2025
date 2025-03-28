@extends('layouts.app')

@section('content')
<h2>Edit Barang</h2>
<form action="{{ route('barang.update', $barang->id) }}" method="POST">
    @csrf @method('PUT')
    Kode: <input type="text" name="barang_kode" value="{{ $barang->barang_kode }}"><br>
    Nama: <input type="text" name="barang_nama" value="{{ $barang->barang_nama }}"><br>
    Harga Beli: <input type="number" name="harga_beli" value="{{ $barang->harga_beli }}"><br>
    Harga Jual: <input type="number" name="harga_jual" value="{{ $barang->harga_jual }}"><br>
    <button type="submit">Update</button>
</form>
@endsection
