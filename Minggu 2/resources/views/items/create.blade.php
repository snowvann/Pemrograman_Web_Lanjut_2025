<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
</head>
<body>
    <h1>Add Item</h1>
    <form action="{{ route('items.store') }}" method="POST">
        @csrf  <!--Token keamanan Laravel untuk mencegah CSRF attack.-->
        <label for="name">Name:</label> <!--Label untuk kolom input-->
        <input type="text" name="name" required> <!--kolom teks untuk nama yang akan dikirim ke backend dan memastikan input ini wajib diisi sebelum form bisa dikirim.-->
        <br>
        <label for="description">Description: </label> <!--label untuk kolom deskripsi, nama atribut akan dikirim ke backend dan wajib diisi sebelum form dikirim-->
        <textarea name="description" required></textarea>
        <br>
        <button type="submit">Add Item</button> <!--tombol mengirim form-->
    </form>
    <a href="{{ route('items.index') }}">Back to List</a>
</body>
</html>