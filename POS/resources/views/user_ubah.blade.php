<!DOCTYPE html>
<html>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="/user">Kembali</a>
    <br><br>

    <form method="post" action="/user/ubah_simpan/{{ $data->id }}">
        {{ csrf_field() }}
        <label>Username</label>
        <input type="text" name="username" value="{{ $data->username }}" placeholder="Masukan Username">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" value="{{ $data->nama }}" placeholder="Masukan Nama">
        <br>
        <label>Password (isi jika ingin mengganti)</label>
        <input type="password" name="password" placeholder="Masukan Password Baru">
        <br>
        <label>Level ID</label>
        <input type="number" name="level_id" value="{{ $data->level_id }}" placeholder="Masukan ID Level">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>
