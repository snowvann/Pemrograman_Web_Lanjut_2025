<form action="{{ url('/level') }}" method="POST">
    @csrf
    <label>Kode Level:</label>
    <input type="text" name="level_kode" required>
    <label>Nama Level:</label>
    <input type="text" name="level_nama" required>
    <button type="submit">Simpan</button>
</form>
