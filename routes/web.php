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

Route::middleware(['auth'])->group(function () {
    Route::get('capturar', [CapturarController::class, 'index'])->name('capturar');

    Route::get('/', [CarrosController::class, 'index'])->name('home');

    Route::prefix('carros')->group(function () {
        Route::get('', [CarrosController::class, 'index'])->name('carros.index');
        Route::post('', [CarrosController::class, 'store'])->name('carros.store');
        Route::delete('{id}', [CarrosController::class, 'destroy'])->name('carros.destroy');
    });

});
