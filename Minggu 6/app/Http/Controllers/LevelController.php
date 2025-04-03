<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class LevelController extends Controller
{
    // Menampilkan Halaman Awal Level
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];
        
        $page = (object) [
            'title' => 'Daftar Level yang terdaftar dalam sistem'
        ];
        $activeMenu = 'level'; //set menu yang sedang aktif
        
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data Level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_name');

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn = '<button onclick="modalEdit(' . $level->level_id . ')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalHapus(' . $level->level_id . ')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create() 
    {
        $breadcrumb = (object) [
            'title' => 'Tambah level',
            'list' => ['Home', 'level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah level baru'
        ];
        
        $level = LevelModel::all(); // Ambil data level untuk ditampilkan di form
        $activeMenu = 'level'; // set menu yang sedang aktif
        
        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
        
    }
    
    //Menyimpan data level baru
    public function store(Request $request)
    {
        $request->validate([
            //level kode harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_level kolom leveln_kode
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_name' => 'required|string|max:100'
        ]);
        
        levelModel::create([
            'level_kode' => $request->level_kode,
            'level_name' => $request->level_name,
        ]);
        
        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }
    
    //Menampilkan detail level
    public function show(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list'  => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Level'
        ];
        $activeMenu = 'level';

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    
    //Menampilkan halaman form edit level
    public function edit(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit level'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    
    //Menyimpan data level baru
    public function update(Request $request, string $id)
    {
        $request->validate([
            //level kode harus diisi, berupa string, minimal 3 karakter, dan 
            //bernilai unik di tabel m_level kolom level_kode kecuali untuk level dengan id yang sedang di edit
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id',
            'level_name' => 'required|string|max:100' // nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);
        
        levelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_name' => $request->level_name,
        ]);
        
        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }
    // Menghapus data level
    public function destroy(string $id)
    {
        $check = LevelModel::find($id);
        if (!$check) {
            return redirect('/level')->with('error','Data level Tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);
            return redirect('/level')->with('success','Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan pesan error
            return redirect('/level')->with('error','Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_name' => 'required|string|max:100|unique:m_level,level_name',
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode' // Tambahkan validasi untuk level_kode
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()->toArray(),
            ]);
        }

        try {
            LevelModel::create([
                'level_name' => $request->level_name,
                'level_kode' => $request->level_kode, // Pastikan level_kode diisi
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan!',
            ]);
        } catch (QueryException $e) {
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

    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.edit_ajax', ['level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_name' => 'required|max:100|unique:m_level,level_name,' . $id . ',level_id',
                'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id' // Tambahkan validasi untuk level_kode
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()->toArray(),
                ]);
            }

            try {
                $level = LevelModel::find($id);
                if ($level) {
                    $level->update($request->all());
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diupdate',
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ]);
                }
            } catch (QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan database: ' . $e->getMessage(),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ]);
            }
        }
        return redirect('/');
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $level = LevelModel::find($id);
                if ($level) {
                    $level->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus',
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ]);
                }
            } catch (QueryException $e) {
               return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan database: ' . $e->getMessage(),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ]);
            }
        }
        return redirect('/');
    }

    public function checkUnique(Request $request, $id = null)
    {
        $levelName = $request->level_name;
        $levelKode = $request->level_kode;
        $query = LevelModel::where('level_name', $levelName);
        $queryKode = LevelModel::where('level_kode', $levelKode);

        if ($id) {
            $query->where('level_id', '!=', $id);
            $queryKode->where('level_id', '!=', $id);
        }

        if ($query->exists() || $queryKode->exists()) {
            return response()->json(false);
        }

        return response()->json(true);
    }

    
}