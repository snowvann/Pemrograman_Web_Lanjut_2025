<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BNG001', 'barang_nama' => 'Toner', 'harga_beli' => 150000, 'harga_jual' => 185000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BNG002', 'barang_nama' => 'Serum', 'harga_beli' => 250000, 'harga_jual' => 315000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'BNG003', 'barang_nama' => 'Rok Plisket', 'harga_beli' => 50000, 'harga_jual' => 65000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'BNG004', 'barang_nama' => 'Kemeja Bunga', 'harga_beli' => 65000, 'harga_jual' => 75000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'BNG005', 'barang_nama' => 'Penggaris', 'harga_beli' => 2500, 'harga_jual' => 4000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'BNG006', 'barang_nama' => 'Kalkulator', 'harga_beli' => 100000, 'harga_jual' => 115000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'BNG007', 'barang_nama' => 'Matras Yoga', 'harga_beli' => 80000, 'harga_jual' => 120000],
            ['barang_id' => 8, 'kategori_id' => 5, 'barang_kode' => 'BNG008', 'barang_nama' => 'Waffer Coklat', 'harga_beli' => 15000, 'harga_jual' => 18500],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'BNG009', 'barang_nama' => 'Yogurt', 'harga_beli' => 10000, 'harga_jual' => 10500],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'BNG010', 'barang_nama' => 'Kopi Susu', 'harga_beli' => 10000, 'harga_jual' => 15000],
            ];

            DB::table('m_barang')->insert($barang);
    }
}