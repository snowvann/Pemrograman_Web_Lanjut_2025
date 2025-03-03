<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {   
        // // mencoba akses model UserModel
        // // Ambil semua data dari tabel m_user
        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        $data = [
            'nama' => 'Pelanggan Pertama',
        ]; 
        UserModel::where('username', 'customer-1')->update($data); //update data user;
        
        // coba akses model UserModel
        $user = UserModel::all();
        return view('user', ['data'=>$user]);
    }
}