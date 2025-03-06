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
        $barang = []; //membuat array kosong $barang yang nantinya akan menampung data barang
        for ($i = 1; $i <= 10; $i++) { // membuat perulangan dari 1 sampai 10
            $barang[] = [ //membuat array baru untuk menampung data barang
                'kategori_id' => rand(1, 5), //mengambil angka acak antara 1 dan 5 untuk kategori_id
                'barang_kode' => 'BRG00' . $i, //mengambil angka acak antara 1 dan 10 untuk barang_kode
                'barang_nama' => 'Barang ' . $i, //mengambil angka acak antara 1 dan 10 untuk barang_nama
                'harga_beli' => rand(1000, 10000), //mengambil angka acak antara 1000 dan 10000 untuk harga_beli
                'harga_jual' => rand(1100, 12000), //mengambil angka acak antara 1000 dan 10000 untuk harga_jual
                'created_at' => now(), //mengambil waktu sekarang untuk created_at
                'updated_at' => now(), //mengambil waktu sekarang untuk updated_at
            ];
        }

        DB::table('m_barang')->insert($barang); //menggunakan fungsi insert untuk menambahkan data ke tabel m_barang
    }
}
