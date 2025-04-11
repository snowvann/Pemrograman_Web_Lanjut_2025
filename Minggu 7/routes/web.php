<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    WelcomeController,
    KategoriController,
    UserController,
    LevelController,
    SupplierController,
    BarangController
};

// Global pattern untuk parameter 'id'
Route::pattern('id', '[0-9]+');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);

    // USER
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/list', [UserController::class, 'list']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::get('/{id}', [UserController::class, 'show']);

        // AJAX
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/ajax', [UserController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::put('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
        Route::post('/check_unique/{id?}', [UserController::class, 'checkUnique'])->name('user.check_unique');
    });

    // LEVEL
    Route::middleware('authorize:ADM')->group(function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::post('/list', [LevelController::class, 'list']);
        Route::get('/create', [LevelController::class, 'create']);
        Route::post('/', [LevelController::class, 'store']);
        Route::get('/{id}/edit', [LevelController::class, 'edit']);
        Route::put('/{id}', [LevelController::class, 'update']);
        Route::delete('/{id}', [LevelController::class, 'destroy']);
        Route::get('/{id}', [LevelController::class, 'show']);

        // AJAX
        Route::get('/create_ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
        Route::post('/ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax');
        Route::post('/check_unique/{id?}', [LevelController::class, 'checkUnique'])->name('level.check_unique');
    });

    // KATEGORI
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index']);
        Route::post('/list', [KategoriController::class, 'list']);
        Route::get('/create', [KategoriController::class, 'create']);
        Route::post('/', [KategoriController::class, 'store']);
        Route::get('/{id}/edit', [KategoriController::class, 'edit']);
        Route::put('/{id}', [KategoriController::class, 'update']);
        Route::delete('/{id}', [KategoriController::class, 'destroy']);
        Route::get('/{id}', [KategoriController::class, 'show']);

        // AJAX
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax'])->name('kategori.create_ajax');
        Route::post('/ajax', [KategoriController::class, 'store_ajax'])->name('kategori.store_ajax');
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax'])->name('kategori.edit_ajax');
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax'])->name('kategori.update_ajax');
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax'])->name('kategori.delete_ajax');
        Route::post('/check_unique/{id?}', [KategoriController::class, 'check_unique'])->name('kategori.check_unique');
    });

    // SUPPLIER
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::post('/list', [SupplierController::class, 'list']);
        Route::get('/create', [SupplierController::class, 'create']);
        Route::post('/', [SupplierController::class, 'store']);
        Route::get('/{id}/edit', [SupplierController::class, 'edit']);
        Route::put('/{id}', [SupplierController::class, 'update']);
        Route::delete('/{id}', [SupplierController::class, 'destroy']);
        Route::get('/{id}', [SupplierController::class, 'show']);

        // AJAX
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax'])->name('supplier.create_ajax');
        Route::post('/ajax', [SupplierController::class, 'store_ajax'])->name('supplier.store_ajax');
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax'])->name('supplier.edit_ajax');
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax'])->name('supplier.update_ajax');
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax'])->name('supplier.delete_ajax');
        Route::post('/check_unique/{id?}', [SupplierController::class, 'checkUnique'])->name('supplier.check_unique');
    });

    // BARANG
    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/list', [BarangController::class, 'list']);
        Route::get('/create', [BarangController::class, 'create']);
        Route::post('/', [BarangController::class, 'store']);
        Route::get('/{id}/edit', [BarangController::class, 'edit']);
        Route::put('/{id}', [BarangController::class, 'update']);
        Route::delete('/{id}', [BarangController::class, 'destroy']);
        Route::get('/{id}', [BarangController::class, 'show']);

        // AJAX
        Route::get('/create_ajax', [BarangController::class, 'create_ajax'])->name('barang.create_ajax');
        Route::post('/ajax', [BarangController::class, 'store_ajax'])->name('barang.store_ajax');
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax'])->name('barang.edit_ajax');
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax'])->name('barang.update_ajax');
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax'])->name('barang.delete_ajax');
        Route::post('/check_unique/{id?}', [BarangController::class, 'checkUnique'])->name('barang.check_unique');
    });
});
