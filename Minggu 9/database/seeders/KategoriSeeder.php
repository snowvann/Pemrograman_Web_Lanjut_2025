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
        $kategori = [
        ['kategori_id' => 1, 'kategori_kode' => 'SKC', 'kategori_nama' => 'Skincare'],
        ['kategori_id' => 2, 'kategori_kode' => 'PKN', 'kategori_nama' => 'Pakaian'],
        ['kategori_id' => 3, 'kategori_kode' => 'ATK', 'kategori_nama' => 'Alat Tulis Kantor'],
        ['kategori_id' => 4, 'kategori_kode' => 'AOR', 'kategori_nama' => 'Alat Olahraga'],
        ['kategori_id' => 5, 'kategori_kode' => 'FNB', 'kategori_nama' => 'Food and Beverage'],
        ];   

        DB::table('m_kategori')->insert($kategori);
    }
}