<?php

namespace App\Http\Controllers\Main;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\SetoranKeuangan;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * @var ResponseService
     */
    protected $responseService;

    /**
     * Konstruktor untuk menginisialisasi ResponseService.
     *
     * @param ResponseService $responseService
     */
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    /**
     * Menampilkan halaman index dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengembalikan tampilan index dashboard
        return view('main.dashboard.views.index');
    }

    /**
     * Menampilkan laporan siswa dan transaksi hari ini.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showReportOne()
    {
        try {
            // Mendapatkan tahun akademik aktif
            $activeAcademicYear = AppHelper::getActiveAcademicYear();

            // Menghitung jumlah siswa dengan status 'aktif'
            $countAktif = Siswa::countAktif();

            // Menghitung jumlah siswa dengan tagihan untuk tahun akademik aktif
            $countWithTagihan = Siswa::countWithTagihanForTahunAkademik($activeAcademicYear->id_tahun_akademik);

            // Menghitung total jumlah bayar untuk transaksi hari ini
            $totalJumlahBayarToday = Transaksi::totalJumlahBayarToday();

            // Menentukan pesan jika tidak ada data
            $message = ($countAktif === 0 && $countWithTagihan === 0 && $totalJumlahBayarToday === 0) ? 'belum ada data' : 'data ditemukan';

            // Kembalikan response menggunakan responseService
            return $this->responseService->successResponse($message, null, [
                'count_aktif' => $countAktif,
                'count_with_tagihan' => $countWithTagihan,
                'total_jumlah_bayar_today' => $totalJumlahBayarToday,
            ]);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil laporan: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil laporan', $e->getMessage());
        }
    }

    /**
     * Menampilkan laporan total tagihan berdasarkan tahun akademik aktif.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showReportTwo()
    {
        try {
            // Mendapatkan tahun akademik aktif
            $activeAcademicYear = AppHelper::getActiveAcademicYear();

            // Memanggil metode sumTagihan dari model Tagihan
            $totalTagihan = Tagihan::sumTagihan($activeAcademicYear->id_tahun_akademik);

            // Menentukan pesan jika tidak ada data
            $message = ($totalTagihan['total_besar_tagihan'] === 0 &&
                $totalTagihan['total_besar_potongan'] === 0 &&
                $totalTagihan['total_tagihan'] === 0 &&
                $totalTagihan['total_bayar'] === 0)
                ? 'belum ada data'
                : 'data ditemukan';

            // Kembalikan response menggunakan responseService
            return $this->responseService->successResponse($message, null, $totalTagihan);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil total tagihan: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil total tagihan', $e->getMessage());
        }
    }

    /**
     * Menampilkan laporan transaksi hari ini.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showReportThree()
    {
        // Mendapatkan transaksi yang terjadi hari ini
        $transaksiToday = Transaksi::getTransaksiToday();

        // Mengembalikan response menggunakan responseService
        return $this->responseService->successResponse('Data ditemukan', $transaksiToday, []);
    }

    /**
     * Menampilkan laporan transaksi mingguan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showReportFour()
    {
        // Mendapatkan transaksi yang terjadi dalam seminggu terakhir
        $transaksiWeekly = Transaksi::getTransaksiWeekly();

        // Mengembalikan response menggunakan responseService
        return $this->responseService->successResponse('Data ditemukan', $transaksiWeekly, []);
    }

    /**
     * Menampilkan laporan setoran keuangan untuk bulan dan tahun saat ini.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showReportFive()
    {
        // Mendapatkan bulan dan tahun saat ini
        $bulanSekarang = now()->format('m'); // Mengambil bulan dalam format dua digit (01-12)
        $tahunSekarang = now()->year; // Mengambil tahun saat ini (2024)

        // Query untuk mendapatkan data berdasarkan bulan dan tahun saat ini
        $setoranMonthly = SetoranKeuangan::where([
            ['bulan', '=', $bulanSekarang],
            ['tahun', '=', $tahunSekarang]
        ])->first(); // Gunakan first() untuk mengambil satu data yang sesuai

        // Mengembalikan response menggunakan responseService
        return $this->responseService->successResponse('Data ditemukan', $setoranMonthly, []);
    }
}
