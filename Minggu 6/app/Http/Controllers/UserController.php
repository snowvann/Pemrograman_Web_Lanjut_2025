<?php
namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    // Menampilkan halaman awal user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        $level = LevelModel::all(); // ambil data level untuk filter level

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data user dalam bentuk json untuk DataTables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('level_name', function ($user) {
                return $user->level->level_name;
            })
            ->addColumn('aksi', function ($user) {
                $btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        // Menyimpan data user
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,'.$id.',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax() {
        $level = LevelModel::select('level_id', 'level_name')->get();
        return view('user.create_ajax')
                    ->with('level', $level);
    }
    
    public function store_ajax(Request $request)
    {
        // Buat validasi secara manual
        $validator = Validator::make($request->all(), [
            'level_id' => 'required|integer',
            'username' => 'required|min:3|max:20|unique:users,username',
            'nama' => 'required|min:3|max:100',
            'password' => 'required|min:6|max:20',
        ]);

        // Jika validasi gagal, kembalikan error JSON
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()->toArray(), // Perbaikan di sini
            ]);
        }

        try {
            // Simpan data user
            $user = new User();
            $user->level_id = $request->level_id;
            $user->username = $request->username;
            $user->nama = $request->nama;
            $user->password = Hash::make($request->password); // Perbaikan di sini
            $user->save();

            dd($user); // Tambahkan baris ini

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan!',
            ]);
        } catch (QueryException $e) { // Perbaikan di sini
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan database: ' . $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit_ajax(String $id){
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_name')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id){ 
        // cek apakah request dari ajax 
        if ($request->ajax() || $request->wantsJson()) { 
            $rules = [ 
                'level_id' => 'required|integer', 
                'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id', 
                'nama' => 'required|max:100', 
                'password' => 'nullable|min:6|max:20' 
            ];
            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules); 
            
            if ($validator->fails()) { 
                return response()->json([ 
                    'status' => false, // respon json, true: berhasil, false: gagal 
                    'message' => 'Validasi gagal.', 
                    'msgField' => $validator->errors() // menunjukkan field mana yang error 
                    ]); } 
                    
                    $check = UserModel::find($id); 
                    if ($check) { if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari request 
                        $request->request->remove('password'); 
                    } 
                    
                    $check->update($request->all()); 
                    return response()->json([ 
                        'status' => true, 
                        'message' => 'Data berhasil diupdate' 
                    ]); 
                } 
                else{ return response()->json([ 
                    'status' => false, 
                    'message' => 'Data tidak ditemukan' 
                ]); 
            } 
        } 
        return redirect('/');
    }

    public function confirm_ajax(String $id){
        $user = UserModel::find($id);

        return view('user.edit_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah rewuest dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}