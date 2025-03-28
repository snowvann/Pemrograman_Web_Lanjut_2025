@extends('layouts.app')

@section('content')
<h2>Daftar Stok</h2>
<a href="{{ route('stok.create') }}">Tambah Stok</a>
<table border="1">
    <tr>
        <th>Barang ID</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>
    @foreach($stoks as $stok)
    <tr>
        <td>{{ $stok->barang_id }}</td>
        <td>{{ $stok->stok_jumlah }}</td>
        <td>
            <a href="{{ route('stok.edit', $stok->id) }}">Edit</a> |
            <form action="{{ route('stok.destroy', $stok->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
