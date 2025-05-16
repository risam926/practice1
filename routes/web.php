<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/regist',[App\Http\Controllers\HomeController::class, 'showRegistForm'])->name('regist');
Route::post('/regist',[App\Http\Controllers\HomeController::class, 'registSubmit'])->name('submit');

Route::get('/detail/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('detail');

Route::delete('/products/{id}', [App\Http\Controllers\HomeController::class, 'destroy'])->name('product.destroy');


Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit');
Route::put('/update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');

