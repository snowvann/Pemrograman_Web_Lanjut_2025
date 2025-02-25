<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
</head>
<body>
    <h1>Items</h1>
    @if(session('success')) <!--mengechek apakah ada pesan sukses yang disimpan di session-->
        <p class="alert alert-success">{{ session('success') }}</p> <!--menampilkan pesan sukses jika ada-->
    @endif
    <a href="{{ route('items.create') }}">Add Item</a>
    <ul>
        @foreach ($items as $item) <!--menampilkan daftar item menggunakan perulangan-->
            <li>
                {{ $item->name }} - <!--menampilkan nama item dari database-->
                <a href="{{ route('items.edit', $item) }}">Edit</a> <!--mengarahakn ke halaman edit item tertentu-->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach <!--menutup perulangan-->
    </ul>
</body>
</html>