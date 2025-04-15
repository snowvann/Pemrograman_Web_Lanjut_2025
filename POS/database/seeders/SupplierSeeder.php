<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_kode' => 'SUP001',
                'supplier_nama' => 'PT Maju Jaya Abadi',
                'supplier_alamat' => 'Jl. Raya Industri No. 123, Jakarta Utara',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_kode' => 'SUP002',
                'supplier_nama' => 'CV Teknik Mandiri',
                'supplier_alamat' => 'Jl. Pahlawan No. 45, Surabaya',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_kode' => 'SUP003',
                'supplier_nama' => 'UD Sumber Makmur',
                'supplier_alamat' => 'Jl. Kaliurang Km. 10, Yogyakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_kode' => 'SUP004',
                'supplier_nama' => 'PT Sentosa Elektronik',
                'supplier_alamat' => 'Jl. Asia Afrika No. 88, Bandung',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_kode' => 'SUP005',
                'supplier_nama' => 'CV Berkah Sejahtera',
                'supplier_alamat' => 'Jl. Gatot Subroto No. 55, Medan',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
