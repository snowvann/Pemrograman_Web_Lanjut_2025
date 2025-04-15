@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Stok Barang</h3>
    
    <!-- Menampilkan pesan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulir untuk edit stok -->
    <form action="{{ route('stok.update', $stok->stok_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="{{ old('nama_barang', $stok->nama_barang) }}" required>
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" class="form-control" value="{{ old('jumlah', $stok->jumlah) }}" required min="1">
        </div>

        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $item)
                    <option value="{{ $item->kategori_id }}" {{ old('kategori_id', $stok->kategori_id) == $item->kategori_id ? 'selected' : '' }}>
                        {{ $item->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
