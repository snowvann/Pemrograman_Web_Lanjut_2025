@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </h3>
                <span class="badge bg-light text-dark">Halaman Utama</span>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Halo, apakabar!</h5>
                <p>Selamat datang di <strong>Aplikasi Manajemen Data</strong>. Gunakan sidebar untuk navigasi atau klik kotak berikut:</p>

                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/user') }}" class="text-decoration-none">
                            <div class="info-box bg-info text-white p-3 rounded d-flex align-items-center shadow-sm">
                                <i class="fas fa-users fa-2x mr-3"></i>
                                <div>
                                    <h5 class="mb-0">Data Pengguna</h5>
                                    <small>Kelola akun & level</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/barang') }}" class="text-decoration-none">
                            <div class="info-box bg-success text-white p-3 rounded d-flex align-items-center shadow-sm">
                                <i class="fas fa-boxes fa-2x mr-3"></i>
                                <div>
                                    <h5 class="mb-0">Data Barang</h5>
                                    <small>Kategori & Supplier</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/penjualan') }}" class="text-decoration-none">
                            <div class="info-box bg-warning text-white p-3 rounded d-flex align-items-center shadow-sm">
                                <i class="fas fa-cash-register fa-2x mr-3"></i>
                                <div>
                                    <h5 class="mb-0">Penjualan</h5>
                                    <small>Stok & Transaksi</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/kategori') }}" class="text-decoration-none">
                            <div class="info-box bg-secondary text-white p-3 rounded d-flex align-items-center shadow-sm">
                                <i class="far fa-bookmark fa-2x mr-3"></i>
                                <div>
                                    <h5 class="mb-0">Kategori</h5>
                                    <small>Jenis Barang</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/supplier') }}" class="text-decoration-none">
                            <div class="info-box bg-dark text-white p-3 rounded d-flex align-items-center shadow-sm">
                                <i class="fas fa-truck fa-2x mr-3"></i>
                                <div>
                                    <h5 class="mb-0">Supplier</h5>
                                    <small>Data Pemasok</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/stok') }}" class="text-decoration-none">
                            <div class="info-box bg-danger text-white p-3 rounded d-flex align-items-center shadow-sm">
                                <i class="fas fa-cubes fa-2x mr-3"></i>
                                <div>
                                    <h5 class="mb-0">Stok</h5>
                                    <small>Jumlah Ketersediaan</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
