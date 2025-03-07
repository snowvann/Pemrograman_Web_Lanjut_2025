<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() // membuat method untuk mengakses UserModel
    {
        // tambah data user dengan Eloquent Model
        $data = [
            'nama' => 'Pelanggan Pertama', 
        ]; 
        UserModel::where('username', 'customer-1')->update($data); // tambahkan data ke tabel m_user
        
        // coba akses model UserModel
        $user = UserModel::all(); // mengambil semua data user
        return view('user', ['data' => $user]); // mengirim data ke tampilan
    }
}
