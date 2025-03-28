@extends('layouts.app')

@section('content')
<h2>Daftar Barang</h2>
<a href="{{ route('barang.create') }}">Tambah Barang</a>
<table border="1">
    <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Harga Beli</th>
        <th>Harga Jual</th>
        <th>Aksi</th>
    </tr>
    @foreach($barangs as $barang)
    <tr>
        <td>{{ $barang->barang_kode }}</td>
        <td>{{ $barang->barang_nama }}</td>
        <td>{{ $barang->harga_beli }}</td>
        <td>{{ $barang->harga_jual }}</td>
        <td>
            <a href="{{ route('barang.edit', $barang->id) }}">Edit</a> |
            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
