@extends('layouts.template')

@section('content')
<div class="container">
    <h4>Tambah Barang</h4>
    <form action="{{ url('/barang') }}" method="POST" id="form-tambah">
        @csrf
        <div class="form-group">
            <label for="kategori_id">Kategori:</label>
            <select name="kategori_id" id="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="1">BK - Baby Kid</option>
                <option value="2">BH - Beauty Health</option>
                <option value="3">FB - Food Beverage</option>
                <option value="4">HC - Home Care</option>
            </select>
            <small id="error-kategori_id" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="barang_kode">Kode Barang:</label>
            <input type="text" name="barang_kode" id="barang_kode" class="form-control">
        </div>
        <div class="form-group">
            <label for="barang_nama">Nama Barang:</label>
            <input type="text" name="barang_nama" id="barang_nama" class="form-control">
        </div>
        <div class="form-group">
            <label for="harga_beli">Harga Beli:</label>
            <input type="number" name="harga_beli" id="harga_beli" class="form-control">
        </div>
        <div class="form-group">
            <label for="harga_jual">Harga Jual:</label>
            <input type="number" name="harga_jual" id="harga_jual" class="form-control">
        </div>
        <a href="{{ url('/barang') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

{{-- Tempel script validasi AJAX seperti sebelumnya --}}
<script>
// ... kode validasi AJAX dari sebelumnya tetap sama ...
</script>
@endsection
