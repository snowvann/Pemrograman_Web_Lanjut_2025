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
        // Pastikan ada data di tabel t_penjualan dan m_barang
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();
        $barangIds = DB::table('m_barang')->pluck('barang_id')->toArray();

        if (empty($penjualanIds) || empty($barangIds)) {
            return; // Hindari error jika tidak ada data
        }

        $penjualan_detail = [];

        foreach ($penjualanIds as $penjualan_id) {
            for ($j = 1; $j <= 3; $j++) { // 3 barang per transaksi
                $penjualan_detail[] = [
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => $barangIds[array_rand($barangIds)], // Ambil barang secara acak
                    'harga' => rand(1100, 12000),
                    'jumlah' => rand(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($penjualan_detail);
    }
}
