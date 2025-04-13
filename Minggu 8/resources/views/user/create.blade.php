@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Data Stok</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('stok') }}" class="form-horizontal">
            @csrf

            <!-- Stok ID -->
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Stok ID</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="stok_id" name="stok_id" value="{{ old('stok_id') }}" required>
                    @error('stok_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Barang ID -->
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Barang ID</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="barang_id" name="barang_id" value="{{ old('barang_id') }}" required>
                    @error('barang_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- User ID -->
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">User ID</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ old('user_id') }}" required>
                    @error('user_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="form-group row">
                <label class="col-2 control-label col-form-label"></label>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('stok') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
