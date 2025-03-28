@extends('layouts.app')

@section('content')
<h2>Detail Penjualan</h2>
<a href="{{ route('penjualan-detail.create') }}">Tambah Detail</a>
<table border="1">
    <tr>
        <th>Penjualan ID</th>
        <th>Barang ID</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>
    @foreach($penjualan_details as $detail)
    <tr>
        <td>{{ $detail->penjualan_id }}</td>
        <td>{{ $detail->barang_id }}</td>
        <td>{{ $detail->harga }}</td>
        <td>{{ $detail->jumlah }}</td>
        <td>
            <a href="{{ route('penjualan-detail.edit', $detail->id) }}">Edit</a> |
            <form action="{{ route('penjualan-detail.destroy', $detail->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
