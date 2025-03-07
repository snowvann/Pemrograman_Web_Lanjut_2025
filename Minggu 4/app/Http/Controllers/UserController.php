<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() // membuat method untuk mengakses UserModel
    {
        $user = UserModel::where('username', 'manager9')->firstOrFail(); // mengambil semua data user
        return view('user', ['data' => $user]); // mengirim data ke tampilan
    }
}
