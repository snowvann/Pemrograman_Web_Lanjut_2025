<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
         $levels = LevelModel::select('level_id', 'level_kode', 'level_name');;
         
         return DataTables::of($levels) 
         // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
         ->addIndexColumn()  
         ->addColumn('aksi', function ($level) {  // menambahkan kolom aksi 
             $btn  = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn sm">Detail</a> '; 
             $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn warning btn-sm">Edit</a> '; 
             $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">' . csrf_field() . method_field('DELETE') .  
                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data level ini?\');">Hapus</button></form>';      
             return $btn; 
         }) 
         ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
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
 }