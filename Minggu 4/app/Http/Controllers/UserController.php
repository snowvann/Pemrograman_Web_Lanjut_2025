<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index() // membuat method untuk mengakses UserModel
    {
        // tambah data user dengan Eloquent Model
        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3', 
            'password' => Hash::make('12345')
        ]; 
        UserModel::create($data); // menambahkan data ke tabel m_user
        
        // coba akses model UserModel
        $user = UserModel::all(); // mengambil semua data user
        return view('user', ['data' => $user]); // mengirim data ke tampilan
    }
}
