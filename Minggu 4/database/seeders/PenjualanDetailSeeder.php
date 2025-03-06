<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data dari tabel yang diperlukan, pluck digunakan untuk mengubah menjadi array
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();
        $barangList = DB::table('m_barang')->select('barang_id', 'harga_jual')->get();

        // Jika salah satu tabel kosong, hentikan Seeder, jadi berfungsi untuk memastikan data sudah ada
        if (empty($penjualanIds) || $barangList->isEmpty()) {
            return;
        }

        $penjualan_detail = []; // Array untuk menampung data penjualan detail

        foreach ($penjualanIds as $penjualan_id) { // Looping penjualan_id
            for ($j = 1; $j <= 3; $j++) { // 3 barang per transaksi
                // Ambil barang secara acak dari daftar yang sudah diambil
                $barang = $barangList->random();

                $penjualan_detail[] = [ // Buat array untuk menampung data penjualan detail
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => $barang->barang_id,
                    'harga' => $barang->harga_jual, // Harga diambil dari harga_jual
                    'jumlah' => rand(1, 5), // Jumlah acak antara 1 - 5
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert batch untuk meningkatkan performa
        $chunks = array_chunk($penjualan_detail, 50); // Maksimal 50 record per insert
        foreach ($chunks as $chunk) { // Looping chunk
            DB::table('t_penjualan_detail')->insert($chunk); // Insert batch
        }
    }
}
