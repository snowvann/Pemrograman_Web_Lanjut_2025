@extends('layouts.app')

@section('content')

<h2>Daftar Kategori</h2>

<a href="{{ route('kategori.create') }}">Tambah Kategori</a>

<table border="1">
    <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Slug</th>
        <th>Aksi</th>
    </tr>

    @foreach($kategoris as $kategori) <!-- Pastikan looping ini ada -->
    <tr>
        <td>{{ $kategori->kategori_kode }}</td>
        <td>{{ $kategori->kategori_nama }}</td>
        <td>{{ $kategori->kategori_slug }}</td>
        <td>
        <a href="{{ route('kategori.edit', ['kategori' => $kategori->id]) }}">Edit</a> |
            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection
