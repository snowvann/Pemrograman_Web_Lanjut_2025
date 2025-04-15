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
        $data = [
            ['kategori_kode' => 'ELEC', 'kategori_nama' => 'Elektronik'],
            ['kategori_kode' => 'FASH', 'kategori_nama' => 'Fashion'],
            ['kategori_kode' => 'FOOD', 'kategori_nama' => 'Makanan & Minuman'],
            ['kategori_kode' => 'HOME', 'kategori_nama' => 'Peralatan Rumah'],
            ['kategori_kode' => 'AUTO', 'kategori_nama' => 'Otomotif'],
        ];

        DB::table('m_kategori')->insert($data);
    }
}
