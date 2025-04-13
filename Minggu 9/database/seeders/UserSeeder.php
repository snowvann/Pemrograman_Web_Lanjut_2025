<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'level_id' => 1,
                'username' => 'admin1',
                'nama' => 'Admin Satu',
                'password' => Hash::make('123456'), // plain password (tidak direkomendasikan)
            ],
            [
                'user_id' => 2,
                'level_id' => 1,
                'username' => 'admin2',
                'nama' => 'Admin Dua',
                'password' => Hash::make('123456'),
            ],
            [
                'user_id' => 3,
                'level_id' => 2,
                'username' => 'manager1',
                'nama' => 'Manager Satu',
                'password' => Hash::make('123456'),
            ],
            [
                'user_id' => 4,
                'level_id' => 2,
                'username' => 'manager2',
                'nama' => 'Manager Dua',
                'password' => Hash::make('123456'),
            ],
            [
                'user_id' => 5,
                'level_id' => 3,
                'username' => 'staff1',
                'nama' => 'Staff Satu',
                'password' => Hash::make('123456'),
            ],
            [
                'user_id' => 6,
                'level_id' => 3,
                'username' => 'kasir1',
                'nama' => 'Kasir Satu',
                'password' => Hash::make('123456'),
            ],
        ];

        DB::table('m_user')->insert($data);
    }
}
