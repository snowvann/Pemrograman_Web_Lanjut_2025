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
        // // tambah data user dengan Eloquent Model
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3', 
        //     'password' => Hash::make('12345')
        // ]; 
        // UserModel::create($data); // menambahkan data ke tabel m_user
        
        // coba akses model UserModel
        // $user = UserModel::where('level_id',2)->count(); 
        // dd($user);
        // return view('user', ['data' => $user]); // mengirim data ke tampilan

        // $jumlahPengguna = UserModel::where('level_id', 2)->count();
        // return view('user', ['jumlahPengguna' => $jumlahPengguna]);

        $user = UserModel::create( 
            [
                'username' => 'manager11', 
                'nama' => 'Manager11',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        ); 

        $user->username = 'manager12';

        $user->save();

        $user->wasChanged(); //true
        $user->wasChanged('username'); //true
        $user->wasChanged(['username', 'level_id']); //true
        $user->wasChanged('nama'); //false
        dd($user->wasChanged(['nama', 'username'])); //true
    }
}
