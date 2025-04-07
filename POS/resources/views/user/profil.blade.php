<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>Data User</h1>
    <a href="/user/tambah">Tambah User</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Nama</td>
            <td>ID Level Pengguna</td>
            <td>Aksi</td>
        </tr>
    @foreach ($data as $d)
        <tr>
            <td>{{ $d->id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->id_level_pengguna }}</td>
            <td><a href="/user/ubah"{{ $d->user_id }}>Ubah</a><a href="/user"></a></td>
        </tr>

</body>
</html>
