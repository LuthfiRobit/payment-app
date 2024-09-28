<?php

use App\Http\Controllers\Master\IuranController;
use App\Http\Controllers\Master\PotonganController;
use App\Http\Controllers\Master\SiswaController;
use App\Http\Controllers\Master\TahunAkademikController;
use Illuminate\Support\Facades\Route;

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


Route::prefix('master-data')->name('master-data.')->group(function () {

    // Route group untuk Tahun Akademik
    Route::prefix('tahun-akademik')->name('tahun-akademik.')->group(function () {
        Route::get('/', [TahunAkademikController::class, 'index'])->name('index');
        Route::get('/list', [TahunAkademikController::class, 'getData'])->name('list');
        // Route::get('tahun-akademik/create', [TahunAkademikController::class, 'create'])->name('create');
        Route::post('store', [TahunAkademikController::class, 'store'])->name('store');
        Route::get('{id}', [TahunAkademikController::class, 'show'])->name('show');
        // Route::get('tahun-akademik/{id}/edit', [TahunAkademikController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [TahunAkademikController::class, 'update'])->name('update');
        // Route::delete('tahun-akademik/{id}', [TahunAkademikController::class, 'destroy'])->name('destroy');
    });

    // Route group untuk Iuran
    Route::prefix('iuran')->name('iuran.')->group(function () {
        Route::get('/', [IuranController::class, 'index'])->name('index');
        Route::get('/list', [IuranController::class, 'getData'])->name('list');
        Route::post('store', [IuranController::class, 'store'])->name('store');
        Route::get('{id}', [IuranController::class, 'show'])->name('show');
        Route::put('update/{id}', [IuranController::class, 'update'])->name('update');
    });

    // Route group untuk Potongan
    Route::prefix('potongan')->name('potongan.')->group(function () {
        Route::get('/', [PotonganController::class, 'index'])->name('index');
        Route::get('/list', [PotonganController::class, 'getData'])->name('list');
        Route::post('store', [PotonganController::class, 'store'])->name('store');
        Route::get('{id}', [PotonganController::class, 'show'])->name('show');
        Route::put('update/{id}', [PotonganController::class, 'update'])->name('update');
    });

    // Route group untuk Siswa
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('index');
        Route::get('/list', [SiswaController::class, 'getData'])->name('list');
        Route::post('store', [SiswaController::class, 'store'])->name('store');
        Route::get('{id}', [SiswaController::class, 'show'])->name('show');
        Route::put('update/{id}', [SiswaController::class, 'update'])->name('update');
    });
});
