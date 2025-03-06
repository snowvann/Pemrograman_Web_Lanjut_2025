<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stok = []; // membuar array kosong untuk menampung data stok

        for ($i = 1; $i <= 10; $i++) { // membuat loop untuk menambahkan data stok sebanyak 10 kali
            $stok[] = [ // menambahkan data stok ke array
                'barang_id' => $i, // Pastikan ID barang ini ada di tabel m_barang
                'user_id' => 1, // Pastikan user_id ini ada di tabel m_user
                'stok_tanggal' => now(), // tanggal saat ini
                'stok_jual' => rand(10, 100), // Sesuai dengan kolom yang ada di tabel t_stok
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan data ke tabel t_stok
        DB::table('t_stok')->insert($stok);
    }
}
