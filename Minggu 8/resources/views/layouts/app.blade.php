<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
</head>
<body>
    <nav>
        <a href="{{ url('/kategori') }}">Kategori</a> | 
        <a href="{{ url('/level') }}">Level</a> | 
        <a href="{{ url('/user') }}">Pengguna</a> | 
        <a href="{{ url('/barang') }}">Barang</a> | 
        <a href="{{ url('/stok') }}">Stok</a> | 
        <a href="{{ url('/penjualan') }}">Penjualan</a> | 
        <a href="{{ url('/penjualan-detail') }}">Detail Penjualan</a>
    </nav>
    <hr>
    <div>
        @yield('content')
    </div>
</body>
</html>
