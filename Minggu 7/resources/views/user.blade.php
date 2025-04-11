<!DOCTYPE html>
    <html>
        <head>
            <title>Data Level Pengguna</title>
        </head>

        <body>
        <h1>Data User</h1>
        <a href="http://localhost/Pemrograman_Web_Lanjut_2025/Minggu%204/public/user/tambah">+ Tambah User</a>
        <table border="1" cellpadding="2" cellspacing='0'> 
            <tr>
                <td>ID</td>
                <td>Username</td>
                <td>Nama</td>
                <td>IDPengguna</td>
                <td>Kode Level</td>
                <td>Nama Level</td>
            </tr>
            @foreach ($data as $d)
            <tr>
                <td>{{ $d->user_id }}</td>
                <td>{{ $d->username }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->level_id }}</td>
                <td>{{ $d->level->level_kode }}</td>
                <td>{{ $d->level->level_name }}</td>
            <td>
            <a href="http://localhost/Pemrograman_Web_Lanjut_2025/Minggu%204/public/user/ubah/{{ $d->user_id }}">Ubah</a> | <a href="/Pemrograman_Web_Lanjut_2025/Minggu%204/public/user/hapus/{{ $d->user_id }}">Hapus</a>
            </td>
            </tr>
        @endforeach
        </table>
    </body>
    </html>