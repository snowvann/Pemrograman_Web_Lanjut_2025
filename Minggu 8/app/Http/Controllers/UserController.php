<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level'); 
        
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
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

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

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'required|string|max:100', 
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
            return redirect('/user')->with('error','Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_name')->get();

        return view('user.create_ajax')->with('level', $level);
    }
    
    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_id' => 'required|integer',
            'username' => 'required|min:3|max:20|unique:m_user,username',
            'nama' => 'required|min:3|max:100',
            'password' => 'required|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            $user = new UserModel();
            $user->level_id = $request->level_id;
            $user->username = $request->username;
            $user->nama = $request->nama;
            $user->password = bcrypt($request->password);
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

    public function import()
    { 
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

                        if (!isset($value['A'], $value['B'], $value['C'], $value['D'])) continue;

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

    public function export_excel()
    {
        try {
            $users = UserModel::select('user_id', 'level_id', 'nama', 'username')
                ->with('level')
                ->orderBy('level_id')
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Level ID');
            $sheet->setCellValue('C1', 'Nama');
            $sheet->setCellValue('D1', 'Username');

            $row = 2;
            foreach ($users as $key => $user) {
                $sheet->setCellValue('A'.$row, $key + 1);
                $sheet->setCellValue('B'.$row, $user->level->level_name);
                $sheet->setCellValue('C'.$row, $user->nama);
                $sheet->setCellValue('D'.$row, $user->username);
                $row++;
            }

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = 'export_users.xlsx';
            $path = storage_path('app/public/exports/' . $filename);
            $writer->save($path);

            return response()->download($path);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengekspor data: ' . $e->getMessage()
            ]);
        }
    }

    public function export_pdf()
    {
        try {
            $users = UserModel::select('user_id', 'level_id', 'nama', 'username')
                ->with('level')
                ->orderBy('level_id')
                ->get();

            $pdf = Pdf::loadView('user.export_pdf', compact('users'));
            return $pdf->download('export_users.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengekspor data: ' . $e->getMessage()
            ]);
        }
    }

    public function updateProfilePicture(Request $request, $id)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = UserModel::findOrFail($id);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $filename);

            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path('images/profiles/' . $user->profile_picture))) {
                unlink(public_path('images/profiles/' . $user->profile_picture));
            }

            $user->profile_picture = $filename;
            $user->save();
        }

        return redirect()->route('user.show', $user->user_id)
            ->with('success', 'Profile picture updated successfully');
    }
}
