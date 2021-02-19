<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CapturarController;
use App\Http\Controllers\CarrosController;

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

Route::get('capturar', [CapturarController::class, 'index']);
Route::post('capturar', [CapturarController::class, 'store']);


Route::get('carros', [CarrosController::class, 'index']);
Route::delete('carros/{id}', [CarrosController::class, 'destroy']);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware(['auth'])->group(function () {


});
