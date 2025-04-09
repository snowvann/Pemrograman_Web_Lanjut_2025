<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [ // membuat array asosiatif yang berisi daftar kategori produk
            ['kategori_kode' => 'BK', 'kategori_nama' => 'Baby Kid'], 
            ['kategori_kode' => 'BH', 'kategori_nama' => 'Beauty Health'],
            ['kategori_kode' => 'FB', 'kategori_nama' => 'Food Baverage'],
            ['kategori_kode' => 'HC', 'kategori_nama' => 'Home Care']
        ];

        DB::table('m_kategori')->insert($kategori); //menggunakan fungsi insert untuk menambahkan data ke tabel m_kategori
    }
}
