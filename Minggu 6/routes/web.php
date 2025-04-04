<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('/barang', [BarangController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);

Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::get('/user/ubah_simpan', [UserController::class, 'ubah_simpan']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);   // menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);         // menyimpan data user baru Ajax
    Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  // menampilkan halaman form edit user
    Route::put('/{id}update_ajax', [UserController::class, 'update_ajax']);     // menyimpan perubahan data user
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  // menampilkan halaman form edit user
    Route::put('/{id}delete_ajax', [UserController::class, 'delete_ajax']);     // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

Route::get('/{id}',[UserController::class,'show']); // menampilkan detail user
//Tugas
 // m_level
Route::group(['prefix'=>'level'], function(){
    Route::get('/',[LevelController::class,'index']);//menampilkan halaman awal
    Route::post('/list',[LevelController::class,'list']);//menampilkan data level bentuk json / datatables
    Route::get('/create',[LevelController::class,'create']);// meanmpilkan bentuk form untuk tambah level
    Route::post('/',[LevelController::class,'store']);//menyimpan level data baru 
    Route::get('/{id}',[LevelController::class,'show']); // menampilkan detail level
    Route::get('/{id}/edit',[LevelController::class,'edit']);// menampilkan halaman form edit level
    Route::put('/{id}',[LevelController::class,'update']);// menyimpan perubahan data level 
    Route::delete('/{id}',[LevelController::class,'destroy']);// menghapus data level 

    // Rute AJAX
    Route::get('/level/create_ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
    Route::post('/level/store_ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
    Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
    Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
    Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax');
    Route::post('/level/check_unique/{id?}', [LevelController::class, 'checkUnique'])->name('level.check_unique');
});

// m_kategori
Route::group(['prefix'=>'kategori'], function(){
    Route::get('/',[KategoriController::class,'index']);//menampilkan halaman awal
    Route::post('/list',[KategoriController::class,'list']);//menampilkan data kategori bentuk json / datatables
    Route::get('/create',[KategoriController::class,'create']);// meanmpilkan bentuk form untuk tambah kategori
    Route::post('/',[KategoriController::class,'store']);//menyimpan kategori data baru 
    Route::get('/{id}',[KategoriController::class,'show']); // menampilkan detail kategori
    Route::get('/{id}/edit',[KategoriController::class,'edit']);// menampilkan halaman form edit kategori
    Route::put('/{id}',[KategoriController::class,'update']);// menyimpan perubahan data kategori
    Route::delete('/{id}',[KategoriController::class,'destroy']);// menghapus data kategori 

    // Rute AJAX 
    Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax'])->name('kategori.create_ajax');
    Route::post('/kategori/store_ajax', [KategoriController::class, 'store_ajax'])->name('kategori.store_ajax');
    Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax'])->name('kategori.edit_ajax');
    Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax'])->name('kategori.update_ajax');
    Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax'])->name('kategori.delete_ajax');
    Route::post('/kategori/check_unique/{id?}', [KategoriController::class, 'checkUnique'])->name('kategori.check_unique');
});

// m_supplier
Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::delete('/{id}', [SupplierController::class, 'destroy']);

    // Rute AJAX
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax'])->name('supplier.create_ajax');
    Route::post('/store_ajax', [SupplierController::class, 'store_ajax'])->name('supplier.store_ajax');
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax'])->name('supplier.edit_ajax');
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax'])->name('supplier.update_ajax');
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax'])->name('supplier.delete_ajax');
    Route::post('/check_unique/{id?}', [SupplierController::class, 'checkUnique'])->name('supplier.check_unique');
});

// m_barang
Route::group(['prefix'=>'barang'], function(){
    Route::get('/',[BarangController::class,'index']);//menampilkan halaman awal
    Route::post('/list',[BarangController::class,'list']);//menampilkan data barang bentuk json / datatables
    Route::get('/create',[BarangController::class,'create']);// meanmpilkan bentuk form untuk tambah barang
    Route::post('/',[BarangController::class,'store']);//menyimpan barang data baru 
    Route::get('/{id}',[BarangController::class,'show']); // menampilkan detail barang
    Route::get('/{id}/edit',[BarangController::class,'edit']);// menampilkan halaman form edit barang
    Route::put('/{id}',[BarangController::class,'update']);// menyimpan perubahan data baramg
    Route::delete('/{id}',[BarangController::class,'destroy']);// menghapus data barang

    // Rute untuk AJAX
    Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax'])->name('barang.create_ajax');
    Route::post('/barang/store_ajax', [BarangController::class, 'store_ajax'])->name('barang.store_ajax');
    Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax'])->name('barang.edit_ajax');
    Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax'])->name('barang.update_ajax');
    Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax'])->name('barang.delete_ajax');
    Route::post('/barang/check_unique/{id?}', [BarangController::class, 'checkUnique'])->name('barang.check_unique');
});