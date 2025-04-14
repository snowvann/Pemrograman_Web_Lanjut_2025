<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
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

            return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables 
    public function list(Request $request) 
    { 
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id') ->with('level'); 
 
        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }
        
        return DataTables::of($users) 
        // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
        ->addIndexColumn()  
        ->addColumn('aksi', function ($user) {  // menambahkan kolom aksi 
            $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/user/'.$user->user_id).'">'. 
                    csrf_field() . method_field('DELETE') . 
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            return $btn; 
        }) 
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
        ->make(true); 
    }

    public function create() 
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];
        
        $level = LevelModel::all(); // Ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif
        
        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100', // pastikan nama, bukan name
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama, // ini yang diperbaiki
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }


    //Menampilkan detail user
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

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit user
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

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);

    }

    //Menyimpan data user baru
    public function update(Request $request, string $id)
    {
        $request->validate([
            //username harus diisi, berupa string, minimal 3 karakter, dan 
            //bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang di edit
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'nullable|min:5',          // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
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
            return redirect('/user')->with('error','Data User Tidak ditemukan');
        }

        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success','Data User berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan pesan error
            return redirect('/user')->with('error','Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_name' )->get();

        return view('user.create_ajax' )
                    ->with('level', $level);
    }
    
    public function store_ajax(Request $request)
    {
        // Buat validasi secara manual
        $validator = Validator::make($request->all(), [
            'level_id' => 'required|integer',
            'username' => 'required|min:3|max:20|unique:m_user,username',
            'nama' => 'required|min:3|max:100',
            'password' => 'required|min:6|max:20',
        ]);

        // Jika validasi gagal, kembalikan error JSON
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors(),
            ]);
        }
        try {
            // Simpan data user
            $user = new UserModel();
            $user->level_id = $request->level_id;
            $user->username = $request->username;
            $user->nama = $request->nama;
            $user->password = bcrypt($request->password); // Enkripsi password
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }

    public function import() { 
        $breadcrumb = (object) [
            'title' => 'Import Data User',
            'list' => ['Home', 'Barang']
        ];

        $activeMenu = 'user';
        return view('user.import', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $file = $request->file('file_user');

                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true); // kolom A, B, C, dst

                $insert = [];

                if (count($data) > 1) {
                    foreach ($data as $row => $value) {
                        if ($row == 1) continue; // header

                        // Validasi data kosong
                        if (!isset($value['A'], $value['B'], $value['C'], $value['D'])) continue;

                        // Kolom:
                        // A = level_id
                        // B = nama
                        // C = username
                        // D = password

                        $insert[] = [
                            'level_id' => (int) $value['A'],
                            'nama' => trim($value['B']),
                            'username' => trim($value['C']),
                            'password' => Hash::make($value['D']),
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }

                    if (!empty($insert)) {
                        // insertOrIgnore hanya bekerja jika tabel punya constraint unik (misal username)
                        UserModel::insertOrIgnore($insert);

                        return response()->json([
                            'status' => true,
                            'message' => 'Data user berhasil diimport.'
                        ]);
                    }
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang bisa diimport.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/');
}

}