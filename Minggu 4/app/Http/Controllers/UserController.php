<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() // membuat method untuk mengakses UserModel
    {
        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3', 
            'password' => Hash::make('12345')
        ]; 
        UserModel::create($data);
        
        // coba akses model UserModel
        $user = UserModel::all(); // mengambil semua data user
        return view('user', ['data' => $user]); // mengirim data ke tampilan
    }
}
