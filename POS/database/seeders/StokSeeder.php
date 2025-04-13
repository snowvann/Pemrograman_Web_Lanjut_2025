<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil daftar barang yang sudah ada
        $barangList = DB::table('m_barang')->get();

        // Jika tidak ada barang, keluar dari seeder
        if ($barangList->isEmpty()) {
            $this->command->warn('Tidak ada data barang di m_barang. Seeder stok dilewati.');
            return;
        }

        $stok = [];

        foreach ($barangList as $barang) {
            $stok[] = [
                'barang_id' => $barang->barang_id,
                'user_id' => 1, // Pastikan user dengan ID 1 sudah ada
                'stok_tanggal' => now(),
                'stok_jual' => rand(10, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_stok')->insert($stok);

        $this->command->info(count($stok) . ' data stok berhasil diinsert.');
    }
}
