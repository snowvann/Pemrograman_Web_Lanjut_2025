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
        // Pastikan barang_id dan user_id ada di database sebelum melakukan seeding
        $barangIDs = DB::table('m_barang')->pluck('barang_id')->toArray();
        $userIDs = DB::table('m_user')->pluck('user_id')->toArray();

        // Jika tidak ada barang atau user, hentikan proses seeding
        if (empty($barangIDs) || empty($userIDs)) {
            echo "Seeder StokSeeder gagal: Pastikan tabel m_barang dan m_user memiliki data.\n";
            return;
        }

        $stok = [];

        foreach ($barangIDs as $barangID) {
            $stok[] = [
                'barang_id' => $barangID,
                'user_id' => $userIDs[array_rand($userIDs)], // Pilih user_id secara acak dari tabel m_user
                'stok_tanggal' => now(),
                'stok_jual' => rand(10, 100), // Sesuai dengan kolom yang ada di tabel t_stok
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan data ke tabel t_stok
        DB::table('t_stok')->insert($stok);
    }
}
