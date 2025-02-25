<!DOCTYPE html>
<html>
<head>
    <title>Item List</title> <!-- menampilkan judul halaman-->
</head>
<body>
    <h1>Items</h1>
    @if(session('success'))
        <p>{{ session('success')}}</p>
    @endif <!-- session('success') = Mengecek apakah ada pesan sukses yang disimpan di session.-->
    <a href="{{ route('items.create') }}">Add Item</a> <!--menghasilkan URL untuk halaman tambah item-->
    <ul>
        @foreach ($items as $item) <!--Looping setiap item yang dikirim dari controller.-->
        <li>
            {{ $item->name }} - <!--menampilkan nama item-->
            <a href="{{ route('items.edit', $item) }}">Edit</a>
            <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                @csrf <!--Token keamanan Laravel untuk mencegah CSRF attack.-->
                @method('DELETE') <!--mengubah menjadi delete.-->
                <button type="submit">Delete</button>
            </form>
        </li>
        @endforeach
    </ul>
</body>
</html> 