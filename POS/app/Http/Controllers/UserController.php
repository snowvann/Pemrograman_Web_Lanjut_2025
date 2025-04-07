<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\Level; 

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user', ['data' => $users]);
    }


    public function create()
    {
        $levels = Level::all(); // Ambil semua level
        return view('user.create', compact('levels'));
    }
    

    public function store(Request $request)
    {
        DB::table('m_user')->insert([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/user');
    }

    public function edit($id)
    {
        $user = DB::table('m_user')->where('id', $id)->first();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->level_id = $request->level_id;
        $user->username = $request->username;
        $user->nama = $request->nama;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/user');
    }


    public function destroy($id)
    {
        DB::table('m_user')->where('id', $id)->delete();
        return redirect('/user');
    }

    public function tambah() 
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request) 
    {
        User::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah($id) 
    {
        $user = User::find($id);
        return view('user_ubah', ['data' => $user]);
    }


    public function ubah_simpan($id, Request $request) 
    {
        $user = User::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id) 
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/user');
    }

}

