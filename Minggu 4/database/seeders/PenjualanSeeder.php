<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualan = []; // array kosong untuk menampung data penjualan

        for ($i = 1; $i <= 10; $i++) { // loop untuk menambahkan 10 data penjualan
            $penjualan[] = [ // menambahkan data penjualan ke array
                'user_id' => 1, // Pastikan user_id ini ada di tabel m_user
                'penjualan_kode' => 'PJL00' . $i, // membuat kode penjualan unik
                'penjualan_tanggal' => now(), // menambahkan tanggal penjualan
                'harga_beli' => rand(50000, 200000), // Menambahkan harga_beli sesuai tabel
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_penjualan')->insert($penjualan); // menambahkan data ke tabel t_penjualan
    }
}
