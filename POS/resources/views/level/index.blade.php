<!DOCTYPE html>
<html>
<head>
    <title>Level</title>
</head>
<body>
    <h1>Daftar Level</h1>
    <a href="{{ url('/level/create') }}">Tambah Level</a>
    <ul>
        @foreach ($levels as $level)
            <li>{{ $level->level_kode }} - {{ $level->level_nama }} 
                <a href="{{ url('/level/' . $level->id . '/edit') }}">Edit</a> |
                <form action="{{ url('/level/' . $level->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
