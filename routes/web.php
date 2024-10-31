<?php

use App\Http\Controllers\Main\DashboardController;
use App\Http\Controllers\Master\IuranController;
use App\Http\Controllers\Master\PotonganController;
use App\Http\Controllers\Master\SiswaController;
use App\Http\Controllers\Master\TahunAkademikController;
use App\Http\Controllers\Setting\PotonganSiswaController;
use App\Http\Controllers\Setting\TagihanSiswaController;
use App\Http\Controllers\Tagihan\DaftarTagihanController;
use App\Http\Controllers\Tagihan\GenerateTagihanController;
use App\Http\Controllers\Tagihan\RiwayatTagihanController;
use App\Http\Controllers\Transaksi\LaporanController;
use App\Http\Controllers\Transaksi\PembayaranController;
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

Route::prefix('main')->name('main.')->group(
    function () {

        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
            Route::get('/show/report-one', [DashboardController::class, 'showReportOne'])->name('show.report.one');
            Route::get('/show/report-two', [DashboardController::class, 'showReportTwo'])->name('show.report.two');
            Route::get('/show/report-three', [DashboardController::class, 'showReportThree'])->name('show.report.three');
            Route::get('/show/report-four', [DashboardController::class, 'showReportFour'])->name('show.report.four');
        });
    }
);

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
        Route::post('update-status', [TahunAkademikController::class, 'updateStatus'])->name('update.status');
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
        Route::post('import-excel', [SiswaController::class, 'importExcel'])->name('import-excel');
        // Route for global usage
        Route::get('/list/siswa', [SiswaController::class, 'getList'])->name('list-siswa');
    });
});

// Route group untuk setting
Route::prefix('setting')->name('setting.')->group(function () {

    // Route group untuk tagihan siswa
    Route::prefix('tagihan-siswa')->name('tagihan-siswa.')->group(function () {
        Route::get('/', [TagihanSiswaController::class, 'index'])->name('index');
        Route::get('/list', [TagihanSiswaController::class, 'getData'])->name('list');
        // Route::post('store', [TagihanSiswaController::class, 'store'])->name('store');
        Route::post('store-multiple', [TagihanSiswaController::class, 'storeMultiple'])->name('store-multiple');
        Route::get('{id}', [TagihanSiswaController::class, 'show'])->name('show');
        Route::post('update-status', [TagihanSiswaController::class, 'updateStatus'])->name('update-status');
    });

    // Route group untuk potongan siswa
    Route::prefix('potongan-siswa')->name('potongan-siswa.')->group(function () {
        Route::get('/', [PotonganSiswaController::class, 'index'])->name('index');
        Route::get('/list', [PotonganSiswaController::class, 'getData'])->name('list');
        Route::post('store', [PotonganSiswaController::class, 'store'])->name('store');
        // Route::post('store-multiple', [PotonganSiswaController::class, 'storeMultiple'])->name('store-multiple');
        Route::get('{id}', [PotonganSiswaController::class, 'show'])->name('show');
        Route::post('update-status', [PotonganSiswaController::class, 'updateStatus'])->name('update-status');
    });
});

// Route group untuk setting
Route::prefix('tagihan')->name('tagihan.')->group(function () {

    // Route group untuk tagihan siswa
    Route::prefix('generate-tagihan')->name('generate-tagihan.')->group(function () {
        Route::get('/', [GenerateTagihanController::class, 'index'])->name('index');
        Route::get('/list', [GenerateTagihanController::class, 'getData'])->name('list');
        // Route::post('store', [GenerateTagihanController::class, 'store'])->name('store');
        Route::post('store-multiple', [GenerateTagihanController::class, 'storeMultiple'])->name('store-multiple');
        // Route::get('{id}', [GenerateTagihanController::class, 'show'])->name('show');
        // Route::put('update/{id}', [GenerateTagihanController::class, 'update'])->name('update');
    });

    // Route group untuk tagihan siswa
    Route::prefix('daftar-tagihan')->name('daftar-tagihan.')->group(function () {
        Route::get('/', [DaftarTagihanController::class, 'index'])->name('index');
        Route::get('/list', [DaftarTagihanController::class, 'getData'])->name('list');
        // Route::post('store', [GenerateTagihanController::class, 'store'])->name('store');
        // Route::post('store-multiple', [DaftarTagihanController::class, 'storeMultiple'])->name('store-multiple');
        Route::get('{id}', [DaftarTagihanController::class, 'show'])->name('show');
        // Route::put('update/{id}', [GenerateTagihanController::class, 'update'])->name('update');
    });

    // Route group untuk tagihan siswa
    Route::prefix('riwayat-tagihan')->name('riwayat-tagihan.')->group(function () {
        Route::get('/', [RiwayatTagihanController::class, 'index'])->name('index');
        Route::get('/list', [RiwayatTagihanController::class, 'getData'])->name('list');
        Route::get('{id}', [RiwayatTagihanController::class, 'show'])->name('show');
    });
});

// Route group untuk transaksi
Route::prefix('transaksi')->name('transaksi.')->group(function () {

    //Route group untuk pembayaran
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::get('show', [PembayaranController::class, 'show'])->name('show');
        Route::post('store', [PembayaranController::class, 'store'])->name('store');
    });

    //Route group untuk laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/list', [LaporanController::class, 'getData'])->name('list');
        Route::get('/show/{id}', [LaporanController::class, 'show'])->name('show');
        // Route::post('store', [PembayaranController::class, 'store'])->name('store');
    });
});
