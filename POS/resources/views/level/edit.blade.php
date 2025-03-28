<form action="{{ url('/level/' . $level->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Kode Level:</label>
    <input type="text" name="level_kode" value="{{ $level->level_kode }}" required>
    <label>Nama Level:</label>
    <input type="text" name="level_nama" value="{{ $level->level_nama }}" required>
    <button type="submit">Update</button>
</form>
