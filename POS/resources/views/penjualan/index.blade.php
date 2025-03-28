@extends('layouts.app')

@section('content')
<h2>Daftar Penjualan</h2>
<a href="{{ route('penjualan.create') }}">Tambah Penjualan</a>
<table border="1">
    <tr>
        <th>Kode</th>
        <th>Pembeli</th>
        <th>Aksi</th>
    </tr>
    @foreach($penjualans as $penjualan)
    <tr>
        <td>{{ $penjualan->penjualan_kode }}</td>
        <td>{{ $penjualan->pembeli }}</td>
        <td>
            <a href="{{ route('penjualan.edit', $penjualan->id) }}">Edit</a> |
            <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
