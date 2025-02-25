<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf <!--Token keamanan Laravel untuk mencegah serangan CSRF (Cross-Site Request Forgery).-->
        @method('PUT') <!--Laravel menggunakan PUT untuk update data, tapi HTML hanya mendukung GET & POST.-->
        <label for="name">Name: </label>
        <input type="text" name="name" value="{{ $item->name }}" required>
        <br>
        <label for="description">Description: </label>
        <textarea name="description" required>{{ $item->description }}</textarea>
        <br>
        <button type="submit">Update Item</button>
    </form>
    <a href="{{ route('items.index') }}">Back to List</a>
</body>
</html>