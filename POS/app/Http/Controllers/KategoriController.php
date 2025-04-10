<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class KategoriController extends Controller
{
    // Menampilkan Halaman Awal Kategori
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];
            $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori'; //set menu yang sedang aktif
        $kategori = KategoriModel::all(); // ambil semua kategori untuk filter dropdown
            
        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori, 
            'activeMenu' => $activeMenu 
        ]);
        
    }

        // Ambil data kategori dalam bentuk json untuk datatables
    public function list(Request $request) 
    { 
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');;

        if ($request->kategori_id) {
            $kategoris->where('kategori_id', $request->kategori_id);
        }
            
        return DataTables::of($kategoris) 
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
        ->addIndexColumn()  
        ->addColumn('aksi', function ($kategori) {  // menambahkan kolom aksi 
            $btn  = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn sm">Detail</a> '; 
            $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn warning btn-sm">Edit</a> '; 
            $btn .= '<form class="d-inline-block" method="POST" action="'. 
                url('/kategori/'.$kategori->kategori_id).'">' 
                . csrf_field() . method_field('DELETE') .  
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus kategori ini?\');">Hapus</button></form>';      
            return $btn; 
        }) 
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
        ->make(true); 
    }

    public function create() 
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kategori baru'
        ];
            
        $kategori = KategoriModel::all(); // Ambil data kategori untuk ditampilkan di form
        $activeMenu = 'kategori'; // set menu yang sedang aktif
            
        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
            
    }
        
        //Menyimpan data kategori baru
    public function store(Request $request)
    {
        $request->validate([
            //kategori kode harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_kategori kolom kategorin_kode
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100'
        ]);
            
        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);
            
        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }
        
        //Menampilkan detail kategori
    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list'  => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', [
            'breadcrumb'    => $breadcrumb, 
            'page'          => $page, 
            'kategori'      => $kategori, 
            'kategori'      => $kategori, 
            'activeMenu'    => $activeMenu
        ]);
    }
        
        //Menampilkan halaman form edit kategori
    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit Kategori'
        ];
        $activeMenu = 'kategori'; 

        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data barang tidak ditemukan');
        }

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
        
        //Menyimpan data kategori baru
    public function update(Request $request, string $id)
    {
        $request->validate([
                //kategori kode harus diisi, berupa string, minimal 3 karakter, dan 
                //bernilai unik di tabel m_kategori kolom kategori_kode kecuali untuk kategori dengan id yang sedang di edit
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100' // nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);
            
        kategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);
        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }
    
        // Menghapus data kategori
    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error','Data kategori Tidak ditemukan');
        }
    
        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success','Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan pesan error
            return redirect('/kategori')->with('error','Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100|unique:m_kategori,kategori_nama',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()->toArray(),
            ]);
        }

        try {
            $kategori = new KategoriModel();
            $kategori->kategori_kode = $request->kategori_kode;
            $kategori->kategori_nama = $request->kategori_nama;
            $kategori->save();
            
            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan!',
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
        $kategori = KategoriModel::find($id);
        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_nama' => 'required|max:100|unique:m_kategori,kategori_nama,' . $id . ',kategori_id',
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
                $kategori = KategoriModel::find($id);
                if ($kategori) {
                    $kategori->update($request->all());
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
                $kategori = KategoriModel::find($id);
                if ($kategori) {
                    $kategori->delete();
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
        $kategoriName = $request->kategori_nama;
        $query = KategoriModel::where('kategori_nama', $kategoriName);

        if ($id) {
            $query->where('kategori_id', '!=', $id);
        }

        if ($query->exists()) {
            return response()->json(false);
        }

        return response()->json(true);
    }        

}
