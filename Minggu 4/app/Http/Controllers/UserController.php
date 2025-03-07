<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() // membuat method untuk mengakses UserModel
    {
        $user = UserModel::findOr(20, ['username','nama'],function(){ // mencari data user berdasarkan primary key (user_id = 1), hanya mengambil kolom username dan nama.
            abort(404); // jika tidak ditemukan, jalankan callback yang memanggil. abort 404 = mengehntikan eksekusi dan mengembalikan HTTP response 4040 (not found)
        }); // mengambil semua data user
        return view('user', ['data' => $user]); // mengirim data ke tampilan
    }
}
