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
            ['kategori_kode' => 'BABY', 'kategori_nama' => 'BabyKid'], 
            ['kategori_kode' => 'FASH', 'kategori_nama' => 'Fashion'],
            ['kategori_kode' => 'FOOD', 'kategori_nama' => 'Makanan'],
            ['kategori_kode' => 'BEAU', 'kategori_nama' => 'Kecantikan'],
            ['kategori_kode' => 'HOME', 'kategori_nama' => 'HomeCare']
        ];

        DB::table('m_kategori')->insert($kategori); //menggunakan fungsi insert untuk menambahkan data ke tabel m_kategori
    }
}
