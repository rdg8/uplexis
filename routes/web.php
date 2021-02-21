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
Auth::routes();

Route::get('capturar', [CapturarController::class, 'index']);

Route::get('/', [CarrosController::class, 'index'])->name('home');

Route::get('carros', [CarrosController::class, 'index'])->name('carros.index');;
Route::post('carros', [CarrosController::class, 'store'])->name('carros.store');
Route::delete('carros/{id}', [CarrosController::class, 'destroy'])->name('carros.destroy');

Route::middleware(['auth'])->group(function () {


});
