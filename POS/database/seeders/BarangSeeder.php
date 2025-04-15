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
        $data = [
            ['kategori_id' => 1, 'barang_kode' => 'TV001', 'barang_nama' => 'Televisi 42 inch', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['kategori_id' => 1, 'barang_kode' => 'HP002', 'barang_nama' => 'Smartphone 6 inch', 'harga_beli' => 2500000, 'harga_jual' => 2800000],
            ['kategori_id' => 2, 'barang_kode' => 'SHO003', 'barang_nama' => 'Sepatu Sneakers', 'harga_beli' => 400000, 'harga_jual' => 500000],
            ['kategori_id' => 2, 'barang_kode' => 'TSH004', 'barang_nama' => 'Kaos Cotton', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['kategori_id' => 3, 'barang_kode' => 'MIL005', 'barang_nama' => 'Susu UHT 1L', 'harga_beli' => 25000, 'harga_jual' => 30000],
            ['kategori_id' => 3, 'barang_kode' => 'INS006', 'barang_nama' => 'Mie Instan', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['kategori_id' => 4, 'barang_kode' => 'BLD007', 'barang_nama' => 'Blender', 'harga_beli' => 350000, 'harga_jual' => 400000],
            ['kategori_id' => 4, 'barang_kode' => 'IRN008', 'barang_nama' => 'Setrika', 'harga_beli' => 150000, 'harga_jual' => 180000],
            ['kategori_id' => 5, 'barang_kode' => 'OL009', 'barang_nama' => 'Oli Motor 1L', 'harga_beli' => 75000, 'harga_jual' => 90000],
            ['kategori_id' => 5, 'barang_kode' => 'TYR010', 'barang_nama' => 'Ban Motor', 'harga_beli' => 250000, 'harga_jual' => 300000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
