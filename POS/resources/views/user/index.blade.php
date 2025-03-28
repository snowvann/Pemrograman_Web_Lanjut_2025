@extends('layouts.app')

@section('content')
<h2>Daftar Pengguna</h2>
<a href="{{ route('user.create') }}">Tambah Pengguna</a>
<table border="1">
    <tr>
        <th>Username</th>
        <th>Nama</th>
        <th>Level</th>
        <th>Aksi</th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->username }}</td>
        <td>{{ $user->nama }}</td>
        <td>{{ $user->level?->level_nama ?? 'Tidak ada level' }}</td>
        <td>
            <a href="{{ route('user.edit', $user->id) }}">Edit</a> |
            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
