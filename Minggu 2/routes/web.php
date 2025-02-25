<?php

use Illuminate\Support\Facades\Route; //mengimpor Route untuk mendefinisikan rute dalam Laravel.
use App\Http\Controllers\ItemController; //mengimpor ItemCOntroller
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;

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

Route::get('/', [WelcomeController::class,'hello']);

Route::get('/', [PagesController::class,'index']);
Route::get('/about', [PagesController::class,'about']);
Route::get('/articles/{id}', [PagesController::class,'articles']);

Route::get('/', [HomeController::class,'index']);
Route::get('/about', [AboutController::class,'about']);
Route::get('/articles/{id}', [ArticleController::class,'articles']);

Route::resource('photos', PhotoController::class)->only([
    'index', 'show'
]);

Route::resource('photos', PhotoController::class)->except([
    'create', 'store', 'update', 'destroy'
]);

Route::get('/greeting', [WelcomeController::class, 'greeting']);

Route::resource('items', ItemController::class); //membuat semua rute CRUD untuk ItemController