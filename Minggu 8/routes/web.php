<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;

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

Route::pattern('id', '[0-9]+');

// login
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'postlogin']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/register' , [LoginController::class, 'register']);
Route::post('/register', [LoginController::class, 'postregister']);

Route::middleware(['auth'])->group(function () {

    Route::get('/', [WelcomeController::class, 'index']);
    Route::get('/profile', [UserController::class, 'profilePage']);
    Route::post('/user/editPhoto', [UserController::class, 'editPhoto']);

    // user controller
    Route::middleware(['authorize:ADM'])->group(function(){
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list'])->name('user.list'); // menampilkan data user dalam bentuk json untuk datatables
            Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user

            // Create
            Route::get('/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user dengan ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']); // menyimpan data user baru ajax

            // Update
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user dengan ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user dengan ajax

            // Delete
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // menghapus data user dengan ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // menghapus data user dengan ajax

            // Import & Export
            Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']); // AJAX import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']); // ajax form export excel
            Route::get('/export_pdf', [UserController::class, 'export_pdf']); //export pdf
        });
    });

    // level controller
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal Level
            Route::post('/list', [LevelController::class, 'list']); // menampilkan data Level dalam bentuk json untuk datatables
            Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail Level

            // Create
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // menampilkan halaman form tambah Level dengan ajax
            Route::post('/ajax', [LevelController::class, 'store_ajax']); // menyimpan data level baru ajax

            // Update
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // menampilkan halaman form edit Level dengan ajax
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data Level dengan ajax

            // Delete
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // menghapus data level dengan ajax
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // menghapus data level dengan ajax

            // Import & Export
            Route::get('/import', [LevelController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [LevelController::class, 'import_ajax']); // AJAX import excel
            Route::get('/export_excel', [LevelController::class, 'export_excel']); // ajax form export excel
            Route::get('/export_pdf', [LevelController::class, 'export_pdf']); //export pdf
        });
    });

    // kategori controller
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal Kategori
            Route::post('/list', [KategoriController::class, 'list']); // menampilkan data Kategori dalam bentuk json untuk datatables
            Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail Kategori

            // Create
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // menampilkan halaman form tambah kategori dengan ajax
            Route::post('/ajax', [KategoriController::class, 'store_ajax']); // menyimpan data kategori baru ajax

            // Update
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // menampilkan halaman form edit kategori dengan ajax
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data kategori dengan ajax

            // Delete
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // menghapus data kategori dengan ajax
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // menghapus data kategori dengan ajax

            // Import & Export
            Route::get('/import', [KategoriController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // AJAX import excel
            Route::get('/export_excel', [KategoriController::class, 'export_excel']); // ajax form export excel
            Route::get('/export_pdf', [KategoriController::class, 'export_pdf']); //export pdf
        });
    });

    // barang controller
    // Staff hanya bisa melihat data barang
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal Barang
            Route::post('/list', [BarangController::class, 'list']); // menampilkan data Barang dalam bentuk json untuk datatables
            Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail Barang
        });
    });

    // ADM & MNG bisa menambah, mengedit, dan menghapus barang
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'barang'], function () {
            // Create
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah barang dengan ajax
            Route::post('/ajax', [BarangController::class, 'store_ajax']); // menyimpan data barang baru ajax

            // Update
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // menampilkan halaman form edit barang dengan ajax
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data barang dengan ajax

            // Delete
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // menghapus data barang dengan ajax
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // menghapus data barang dengan ajax

            // Import & Export
            Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // AJAX import excel
            Route::get('/export_excel', [BarangController::class, 'export_excel']); // ajax form export excel
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']); //export pdf
        });
    });

    // supplier controller
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal Supplier
            Route::post('/list', [SupplierController::class, 'list']); // menampilkan data Supplier dalam bentuk json untuk datatables
            Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail Supplier

            // Create
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah Supplier dengan ajax
            Route::post('/ajax', [SupplierController::class, 'store_ajax']); // menyimpan data Supplier baru ajax

            // Update
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // menampilkan halaman form edit Supplier dengan ajax
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data Supplier dengan ajax

            // Delete
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // menghapus data Supplier dengan ajax
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // menghapus data Supplier dengan ajax

            // Import & Export
            Route::get('/import', [SupplierController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // AJAX import excel
            Route::get('/export_excel', [SupplierController::class, 'export_excel']); // ajax form export excel
            Route::get('/export_pdf', [SupplierController::class, 'export_pdf']); //export pdf
        });
    });
});
