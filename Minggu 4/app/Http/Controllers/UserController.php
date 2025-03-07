<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $jumlahPengguna = UserModel::where('level_id', 2)->count(); 
        return view('user', ['jumlahPengguna' => $jumlahPengguna]);
    }
}
