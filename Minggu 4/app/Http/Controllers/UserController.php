<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33', 
                'nama' => 'Manager Tiga Tiga',
                'level_id' => 2, // Kriteria pencarian
            ],
            [
                'password' => Hash::make('12345') // Data tambahan jika tidak ditemukan
            ]
        );
    
        $user->save(); // Simpan data baru ke database
    
        return view('user', ['data' => $user]); // Mengirim data ke tampilan
    }    
}