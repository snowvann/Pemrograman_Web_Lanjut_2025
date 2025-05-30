@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title ?? 'Edit Supplier' }}</h3>
    </div>
    <div class="card-body">
        @if (!$supplier)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('supplier') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/supplier/'.$supplier->supplier_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kode Supplier</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="supplier_kode" name="supplier_kode" value="{{ old('supplier_kode', $supplier->supplier_kode ?? '') }}" required>
                        @error('supplier_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Supplier</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="supplier_nama" name="supplier_nama" value="{{ old('supplier_nama', $supplier->supplier_nama ?? '') }}" required>
                        @error('supplier_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Alamat Supplier</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="alamat_supplier" name="alamat_supplier" value="{{ old('alamat_supplier', $supplier->alamat_supplier ?? '') }}" required>
                        @error('alamat_supplier')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('supplier') }}">Kembali</a>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush