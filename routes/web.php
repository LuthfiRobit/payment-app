<?php

use App\Http\Controllers\Apps\ProfilController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Landpage\ArtikelLandpageController;
use App\Http\Controllers\Landpage\BeritaLandpageController;
use App\Http\Controllers\Landpage\GaleriLandpageController;
use App\Http\Controllers\Landpage\GuruLandpageController;
use App\Http\Controllers\Landpage\LandpageController;
use App\Http\Controllers\Landpage\PpdbLandpageController;
use App\Http\Controllers\Landpage\PrestasiLandpageController;
use App\Http\Controllers\Main\DashboardController;
use App\Http\Controllers\Main\DashboardPpdbController;
use App\Http\Controllers\Master\ArtikelController;
use App\Http\Controllers\Master\GaleriController;

use App\Http\Controllers\Master\BeritaController;
use App\Http\Controllers\Master\GuruController;
use App\Http\Controllers\Master\IuranController;
use App\Http\Controllers\Master\KontakController;
use App\Http\Controllers\Master\PotonganController;
use App\Http\Controllers\Master\PrestasiController;
use App\Http\Controllers\Master\SiswaController;
use App\Http\Controllers\Master\TahunAkademikController;
use App\Http\Controllers\Master\TentangController;
use App\Http\Controllers\Registrasi\RegistrasiController;
use App\Http\Controllers\Registrasi\RegistrasiGeneratorController;
use App\Http\Controllers\Registrasi\RegistrasiSettingController;
use App\Http\Controllers\Registrasi\RegistrasiSiswaController;
use App\Http\Controllers\Setting\PotonganSiswaController;
use App\Http\Controllers\Setting\TagihanSiswaController;
use App\Http\Controllers\Tagihan\DaftarTagihanController;
use App\Http\Controllers\Tagihan\GenerateTagihanController;
use App\Http\Controllers\Tagihan\RiwayatTagihanController;
use App\Http\Controllers\Transaksi\LaporanController;
use App\Http\Controllers\Transaksi\PembayaranController;
use App\Http\Controllers\Transaksi\SetorKeuanganController;
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
    return view('landpage.beranda.views.index');
});

Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('auth.form');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');

Route::prefix('main')->name('main.')->group(
    function () {

        Route::middleware(['auth', 'role:developer,kepsek,bendahara,petugas_pembayaran'])->prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
            Route::get('/show/report-one', [DashboardController::class, 'showReportOne'])->name('show.report.one');
            Route::get('/show/report-two', [DashboardController::class, 'showReportTwo'])->name('show.report.two');
            Route::get('/show/report-three', [DashboardController::class, 'showReportThree'])->name('show.report.three');
            Route::get('/show/report-four', [DashboardController::class, 'showReportFour'])->name('show.report.four');
            Route::get('/show/report-five', [DashboardController::class, 'showReportFive'])->name('show.report.five');
        });

        Route::middleware(['auth', 'role:developer,kepsek,petugas_emis'])->prefix('dashboard-ppdb')->name('dashboard-ppdb.')->group(function () {
            Route::get('/', [DashboardPpdbController::class, 'index'])->name('index');
            Route::get('/show/report-one', [DashboardPpdbController::class, 'showReportOne'])->name('show.report.one');
            Route::get('/show/report-two', [DashboardPpdbController::class, 'showReportTwo'])->name('show.report.two');
            Route::get('/show/report-three', [DashboardPpdbController::class, 'showReportThree'])->name('show.report.three');
        });
    }
);

Route::prefix('master-data')->name('master-data.')->group(function () {

    // Route group untuk Tahun Akademik
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran,petugas_emis'])->prefix('tahun-akademik')->name('tahun-akademik.')->group(function () {
        // Rute yang bisa diakses oleh semua role (kepsek, developer, petugas_pembayaran)
        Route::get('/', [TahunAkademikController::class, 'index'])->name('index');
        Route::get('/list', [TahunAkademikController::class, 'getData'])->name('list');

        Route::post('store', [TahunAkademikController::class, 'store'])->name('store');
        Route::get('{id}', [TahunAkademikController::class, 'show'])->name('show');
        Route::put('update/{id}', [TahunAkademikController::class, 'update'])->name('update');
        Route::post('update-status', [TahunAkademikController::class, 'updateStatus'])->name('update.status');
    });


    // Route group untuk Iuran
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran'])->prefix('iuran')->name('iuran.')->group(function () {
        // Rute yang bisa diakses oleh semua role (kepsek, developer, petugas_pembayaran)
        Route::get('/', [IuranController::class, 'index'])->name('index');
        Route::get('/list', [IuranController::class, 'getData'])->name('list');

        // Rute yang hanya bisa diakses oleh developer dan petugas_pembayaran
        Route::middleware('role:developer,petugas_pembayaran')->group(function () {
            Route::post('store', [IuranController::class, 'store'])->name('store');
            Route::get('{id}', [IuranController::class, 'show'])->name('show');
            Route::put('update/{id}', [IuranController::class, 'update'])->name('update');
        });
    });

    // Route group untuk Potongan
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran'])->prefix('potongan')->name('potongan.')->group(function () {
        // Rute yang bisa diakses oleh semua role (kepsek, developer, petugas_pembayaran)
        Route::get('/', [PotonganController::class, 'index'])->name('index');
        Route::get('/list', [PotonganController::class, 'getData'])->name('list');

        // Rute yang hanya bisa diakses oleh developer dan petugas_pembayaran
        Route::middleware('role:developer,petugas_pembayaran')->group(function () {
            Route::post('store', [PotonganController::class, 'store'])->name('store');
            Route::get('{id}', [PotonganController::class, 'show'])->name('show');
            Route::put('update/{id}', [PotonganController::class, 'update'])->name('update');
        });
    });

    // Route group untuk Siswa
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran'])->prefix('siswa')->name('siswa.')->group(function () {
        // Rute yang bisa diakses oleh semua role
        Route::get('/', [SiswaController::class, 'index'])->name('index');
        Route::get('/list', [SiswaController::class, 'getData'])->name('list');
        Route::get('{id}', [SiswaController::class, 'show'])->name('show');
        Route::get('/list/siswa', [SiswaController::class, 'getList'])->name('list-siswa');

        // Rute yang hanya bisa diakses oleh developer dan petugas pembayaran
        Route::middleware('role:developer,petugas_pembayaran')->group(function () {
            Route::post('store', [SiswaController::class, 'store'])->name('store');
            Route::put('update/{id}', [SiswaController::class, 'update'])->name('update');
            Route::post('update-kelas', [SiswaController::class, 'updateKelas'])->name('update.kelas');
            Route::post('import-excel', [SiswaController::class, 'importExcel'])->name('import-excel');
        });
    });

    // Route group untuk Guru
    Route::middleware(['auth', 'role:developer,kepsek,petugas_emis'])->prefix('guru')->name('guru.')->group(function () {
        // Rute yang bisa diakses oleh semua role
        Route::get('/', [GuruController::class, 'index'])->name('index');
        Route::get('/list', [GuruController::class, 'getData'])->name('list');
        Route::get('{id}', [GuruController::class, 'show'])->name('show');

        // Rute yang hanya bisa diakses oleh developer dan petugas emis
        Route::middleware('role:developer,petugas_emis')->group(function () {
            Route::post('store', [GuruController::class, 'store'])->name('store');
            Route::put('update/{id}', [GuruController::class, 'update'])->name('update');
        });
    });

    // Route group untuk Kontak
    Route::middleware(['auth', 'role:developer,kepsek,petugas_emis'])->prefix('kontak')->name('kontak.')->group(function () {
        Route::get('/', [KontakController::class, 'index'])->name('index');
        Route::get('/list', [KontakController::class, 'getData'])->name('list');
        Route::post('store', [KontakController::class, 'store'])->name('store');
        Route::get('{id}', [KontakController::class, 'show'])->name('show');
        Route::put('update/{id}', [KontakController::class, 'update'])->name('update');
        Route::post('update-status', [KontakController::class, 'updateStatus'])->name('update.status');
    });

    // Route group untuk Tentang
    Route::middleware(['auth', 'role:developer,kepsek,petugas_emis'])->prefix('tentang')->name('tentang.')->group(function () {
        Route::get('/', [TentangController::class, 'index'])->name('index');
        Route::get('/list', [TentangController::class, 'getData'])->name('list');
        Route::post('store', [TentangController::class, 'store'])->name('store');
        Route::get('{id}', [TentangController::class, 'show'])->name('show');
        Route::put('update/{id}', [TentangController::class, 'update'])->name('update');
        Route::post('update-status', [TentangController::class, 'updateStatus'])->name('update.status');
    });

    // Route group untuk Galeri
    Route::middleware(['auth', 'role:developer,kepsek,petugas_emis'])->prefix('galeri')->name('galeri.')->group(function () {
        Route::get('/', [GaleriController::class, 'index'])->name('index');
        Route::get('/list', [GaleriController::class, 'getData'])->name('list');
        Route::post('store', [GaleriController::class, 'store'])->name('store');
        Route::get('{id}', [GaleriController::class, 'show'])->name('show');
        Route::put('update/{id}', [GaleriController::class, 'update'])->name('update');
        Route::post('update-status', [GaleriController::class, 'updateStatus'])->name('update.status');
    });

    // Route group untuk Prestasi
    Route::middleware(['auth', 'role:developer,kepsek,petugas_emis'])->prefix('prestasi')->name('prestasi.')->group(function () {
        Route::get('/', [PrestasiController::class, 'index'])->name('index');
        Route::get('/list', [PrestasiController::class, 'getData'])->name('list');
        Route::post('store', [PrestasiController::class, 'store'])->name('store');
        Route::get('{id}', [PrestasiController::class, 'show'])->name('show');
        Route::put('update/{id}', [PrestasiController::class, 'update'])->name('update');
        Route::post('update-status', [PrestasiController::class, 'updateStatus'])->name('update.status');
    });

    // Route group untuk Berita
    Route::middleware(['auth', 'role:developer,kepsek,petugas_emis'])->prefix('berita')->name('berita.')->group(function () {
        // Rute yang bisa diakses oleh semua role (kepsek, developer, petugas_pembayaran)
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/list', [BeritaController::class, 'getData'])->name('list');
        Route::post('store', [BeritaController::class, 'store'])->name('store');
        Route::get('{id}', [BeritaController::class, 'show'])->name('show');
        Route::put('update/{id}', [BeritaController::class, 'update'])->name('update');
    });

    // Route group untuk Artikel
    Route::middleware(['auth', 'role:developer,kepsek,petugas_emis'])->prefix('artikel')->name('artikel.')->group(function () {
        // Rute yang bisa diakses oleh semua role (kepsek, developer, petugas_pembayaran)
        Route::get('/', [ArtikelController::class, 'index'])->name('index');
        Route::get('/list', [ArtikelController::class, 'getData'])->name('list');
        Route::post('store', [ArtikelController::class, 'store'])->name('store');
        Route::get('{id}', [ArtikelController::class, 'show'])->name('show');
        Route::put('update/{id}', [ArtikelController::class, 'update'])->name('update');
    });
});

// Route group untuk setting
Route::prefix('setting')->name('setting.')->group(function () {

    // Route group untuk Tagihan Siswa
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran'])->prefix('tagihan-siswa')->name('tagihan-siswa.')->group(function () {
        // Rute yang bisa diakses oleh semua role (kepsek, developer, petugas_pembayaran)
        Route::get('/', [TagihanSiswaController::class, 'index'])->name('index');
        Route::get('/list', [TagihanSiswaController::class, 'getData'])->name('list');

        // Rute yang hanya bisa diakses oleh developer dan petugas_pembayaran
        Route::middleware('role:developer,petugas_pembayaran')->group(function () {
            Route::post('store-multiple', [TagihanSiswaController::class, 'storeMultiple'])->name('store-multiple');
            Route::post('update-status', [TagihanSiswaController::class, 'updateStatus'])->name('update-status');
        });

        // Route untuk melihat tagihan berdasarkan id, dapat diakses oleh semua role
        Route::get('{id}', [TagihanSiswaController::class, 'show'])->name('show');
    });

    // Route group untuk Potongan Siswa
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran'])->prefix('potongan-siswa')->name('potongan-siswa.')->group(function () {
        // Rute yang bisa diakses oleh semua role (kepsek, developer, petugas_pembayaran)
        Route::get('/', [PotonganSiswaController::class, 'index'])->name('index');
        Route::get('/list', [PotonganSiswaController::class, 'getData'])->name('list');

        // Rute yang hanya bisa diakses oleh developer dan petugas_pembayaran
        Route::middleware('role:developer,petugas_pembayaran')->group(function () {
            Route::post('store', [PotonganSiswaController::class, 'store'])->name('store');
            Route::post('update-status', [PotonganSiswaController::class, 'updateStatus'])->name('update-status');
        });

        // Route untuk melihat potongan berdasarkan id, dapat diakses oleh semua role
        Route::get('{id}', [PotonganSiswaController::class, 'show'])->name('show');
    });
});

// Route group untuk setting
Route::prefix('tagihan')->name('tagihan.')->group(function () {

    // Route group untuk generate tagihan siswa
    Route::middleware(['auth', 'role:developer,petugas_pembayaran'])->prefix('generate-tagihan')->name('generate-tagihan.')->group(function () {
        Route::get('/', [GenerateTagihanController::class, 'index'])->name('index');
        Route::get('/list', [GenerateTagihanController::class, 'getData'])->name('list');
        Route::post('store-multiple', [GenerateTagihanController::class, 'storeMultiple'])->name('store-multiple');
    });

    // Route group untuk daftar tagihan siswa tahun akademik aktif
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran'])->prefix('daftar-tagihan')->name('daftar-tagihan.')->group(function () {
        Route::get('/', [DaftarTagihanController::class, 'index'])->name('index');
        Route::get('/list', [DaftarTagihanController::class, 'getData'])->name('list');
        Route::get('{id}', [DaftarTagihanController::class, 'show'])->name('show');
    });

    // Route group untuk riwayat tagihan siswa
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran'])->prefix('riwayat-tagihan')->name('riwayat-tagihan.')->group(function () {
        Route::get('/', [RiwayatTagihanController::class, 'index'])->name('index');
        Route::get('/list', [RiwayatTagihanController::class, 'getData'])->name('list');
        Route::get('{id}', [RiwayatTagihanController::class, 'show'])->name('show');
    });
});

// Route group untuk transaksi
Route::prefix('transaksi')->name('transaksi.')->group(function () {

    //Route group untuk pembayaran
    Route::middleware(['auth', 'role:developer,petugas_pembayaran'])->prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::get('show', [PembayaranController::class, 'show'])->name('show');
        Route::post('store', [PembayaranController::class, 'store'])->name('store');
    });

    //Route group untuk laporan
    Route::middleware(['auth', 'role:developer,kepsek,petugas_pembayaran'])->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/list', [LaporanController::class, 'getData'])->name('list');
        Route::get('/show/{id}', [LaporanController::class, 'show'])->name('show');
        Route::post('export', [LaporanController::class, 'export'])->name('export');
    });

    // Route group untuk Setor Keuangan
    Route::middleware(['auth', 'role:developer,kepsek,bendahara'])->prefix('setor-keuangan')->name('setor.keuangan.')->group(function () {
        // Rute yang bisa diakses oleh semua role (kepsek, developer, bendahara)
        Route::get('/', [SetorKeuanganController::class, 'index'])->name('index');
        Route::get('/list', [SetorKeuanganController::class, 'getData'])->name('list');
        Route::get('/show/{id}', [SetorKeuanganController::class, 'show'])->name('show');

        // Rute yang hanya bisa diakses oleh developer dan bendahara
        Route::middleware('role:developer,bendahara')->group(function () {
            Route::get('create', [SetorKeuanganController::class, 'create'])->name('create');
            Route::get('find', [SetorKeuanganController::class, 'find'])->name('find');
            Route::post('store', [SetorKeuanganController::class, 'store'])->name('store');
            Route::post('export', [SetorKeuanganController::class, 'export'])->name('export');
        });
    });
});

// Route group utama untuk PPDB
Route::middleware(['auth', 'role:developer,petugas_emis,petugas_ppdb,kepsek'])->prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [RegistrasiController::class, 'index'])->name('index');
    Route::get('list', [RegistrasiController::class, 'getData'])->name('list');
    Route::get('create', [RegistrasiController::class, 'create'])->name('create');
    Route::post('store', [RegistrasiSiswaController::class, 'store'])->name('store');

    // Hanya bisa diakses oleh developer dan petugas emis
    Route::middleware(['role:developer,petugas_emis'])->group(function () {
        Route::post('export', [RegistrasiController::class, 'export'])->name('export');
        Route::post('generate', [RegistrasiGeneratorController::class, 'generate'])->name('generate');

        // Route group untuk setting (hanya untuk developer & petugas emis)
        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('/', [RegistrasiSettingController::class, 'index'])->name('index');
            Route::get('/list', [RegistrasiSettingController::class, 'getData'])->name('list');
            Route::post('store', [RegistrasiSettingController::class, 'store'])->name('store');
            Route::get('{id}', [RegistrasiSettingController::class, 'show'])->name('show');
            Route::put('update/{id}', [RegistrasiSettingController::class, 'update'])->name('update');
            Route::post('update-status', [RegistrasiSettingController::class, 'updateStatus'])->name('update.status');
        });
    });

    // Akses umum untuk edit data
    Route::get('show-siswa/{id}', [RegistrasiController::class, 'showSiswa'])->name('show.siswa');
    Route::post('update-siswa/{id}', [RegistrasiController::class, 'updateSiswa'])->name('update.siswa');

    Route::get('show-ortu/{id}', [RegistrasiController::class, 'showOrtu'])->name('show.ortu');
    Route::post('update-ortu/{id}', [RegistrasiController::class, 'updateOrtu'])->name('update.ortu');

    Route::get('show-wali/{id}', [RegistrasiController::class, 'showWali'])->name('show.wali');
    Route::post('update-wali/{id}', [RegistrasiController::class, 'updateWali'])->name('update.wali');

    Route::get('show-keluarga/{id}', [RegistrasiController::class, 'showKeluarga'])->name('show.keluarga');
    Route::post('update-keluarga/{id}', [RegistrasiController::class, 'updateKeluarga'])->name('update.keluarga');

    Route::post('update-status/{id}', [RegistrasiController::class, 'updateStatusSiswa'])->name('update.status');
});


// Route group untuk aplication
Route::prefix('application')->name('application.')->group(function () {

    // Route group untuk user management
    Route::middleware(['auth', 'role:developer,kepsek'])->prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/list', [UserManagementController::class, 'getData'])->name('list');
        Route::post('store', [UserManagementController::class, 'store'])->name('store');
        Route::get('{id}', [UserManagementController::class, 'show'])->name('show');
        Route::put('update/{id}', [UserManagementController::class, 'update'])->name('update');
        Route::post('/update-status', [UserManagementController::class, 'updateStatus'])->name('update.status');
    });

    Route::middleware(['auth'])->prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');
        Route::put('update-data/{id}', [ProfilController::class, 'updateData'])->name('update.data');
        Route::put('update-password/{id}', [ProfilController::class, 'updatePassword'])->name('update.password');
    });
});

// Route group untuk user (guest pada halaman landpage)
Route::middleware('guest')->prefix('landpage')->name('landpage.')->group(function () {
    // Route::get('/', [LandpageController::class, 'index'])->name('index');

    // Route group untuk Prestasi
    Route::prefix('prestasi')->name('prestasi.')->group(function () {
        Route::get('/', [PrestasiLandpageController::class, 'index'])->name('index');
        Route::get('/show-paginate', [PrestasiLandpageController::class, 'showListPaginated'])->name('show.list.paginated');
        Route::get('/show-list', [PrestasiLandpageController::class, 'showList'])->name('show.list');
        Route::get('/{id}', [PrestasiLandpageController::class, 'show'])->name('show');
    });

    // Route group untuk Galeri
    Route::prefix('galeri')->name('galeri.')->group(function () {
        Route::get('/', [GaleriLandpageController::class, 'index'])->name('index');
        Route::get('/show-paginate', [GaleriLandpageController::class, 'showListPaginated'])->name('show.list.paginated');
        Route::get('/show-list', [GaleriLandpageController::class, 'showList'])->name('show.list');
        Route::get('/{id}', [GaleriLandpageController::class, 'show'])->name('show');
    });

    // Route group untuk Berita
    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [BeritaLandpageController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [BeritaLandpageController::class, 'detail'])->name('detail');
        Route::get('/show-paginate', [BeritaLandpageController::class, 'showListPaginated'])->name('show.list.paginated');
        Route::get('/show-list', [BeritaLandpageController::class, 'showList'])->name('show.list');
        Route::get('/{id}', [BeritaLandpageController::class, 'show'])->name('show');
    });

    // Route group untuk Artikel
    Route::prefix('artikel')->name('artikel.')->group(function () {
        Route::get('/', [ArtikelLandpageController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [ArtikelLandpageController::class, 'detail'])->name('detail');
        Route::get('/show-paginate', [ArtikelLandpageController::class, 'showListPaginated'])->name('show.list.paginated');
        Route::get('/show-list', [ArtikelLandpageController::class, 'showList'])->name('show.list');
        Route::get('/{id}', [ArtikelLandpageController::class, 'show'])->name('show');
    });

    // Route group untuk Guru
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [GuruLandpageController::class, 'index'])->name('index');
        Route::get('/show-list', [GuruLandpageController::class, 'showList'])->name('show.list');
    });

    //Route static pages

    Route::get('/profil', function () {
        return view('landpage.profil.views.index');
    })->name('profil.index');

    Route::get('/visi', function () {
        return view('landpage.visi.views.index');
    })->name('visi.index');

    Route::get('/kontak', function () {
        return view('landpage.kontak.views.index');
    })->name('kontak.index');

    Route::get('/akademik', function () {
        return view('landpage.akademik.views.index');
    })->name('akademik.index');

    Route::get('/ekstrakurikuler', function () {
        return view('landpage.ekstrakurikuler.views.index');
    })->name('ekstrakurikuler.index');

    Route::get('/pimpinan', function () {
        return view('landpage.pimpinan.views.index');
    })->name('pimpinan.index');
    //End route static pages

    // Route group untuk PPDB
    Route::prefix('ppdb')->name('ppdb.')->group(function () {
        Route::get('/', [PpdbLandpageController::class, 'index'])->name('index');
        // Route::get('/', [LandpageController::class, 'registration'])->name('registration');
        Route::post('/store', [RegistrasiSiswaController::class, 'store'])->name('store');
    });
});
