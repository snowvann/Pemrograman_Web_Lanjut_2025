<!DOCTYPE html>
<html>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="/Pemrograman_Web_Lanjut_2025/Minggu%204/public/user">Kembali</a>
    <br><br>
    
    <form method="post" action="/Pemrograman_Web_Lanjut_2025/Minggu%204/public/user/ubah_simpan/{{ $data->user_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukan Username">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukan Nama">
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password">
        <br>
        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukan ID Level">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>