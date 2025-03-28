<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\SystemController;

// Route Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Product dengan Prefix
Route::prefix('category')->group(function () {
    Route::get('/food-beverage', [ProductController::class, 'foodBeverage'])->name('category.food-beverage');
    Route::get('/beauty-health', [ProductController::class, 'beautyHealth'])->name('category.beauty-health');
    Route::get('/home-care', [ProductController::class, 'homeCare'])->name('category.home-care');
    Route::get('/baby-kid', [ProductController::class, 'babyKid'])->name('category.baby-kid');
});

// Route User dengan Parameter
Route::get('/user/{id}/name/{name}', [UserController::class, 'showProfile'])->name('user.profile');

// Route Penjualan
Route::get('/sales', [SalesController::class, 'index'])->name('sales');

Route::resource('/kategori', KategoriController::class);
Route::resource('/level', LevelController::class);
Route::resource('/user', UserController::class);
Route::resource('/barang', BarangController::class);
Route::resource('/stok', StokController::class);
Route::resource('/penjualan', PenjualanController::class);
Route::resource('/penjualan-detail', PenjualanDetailController::class);

