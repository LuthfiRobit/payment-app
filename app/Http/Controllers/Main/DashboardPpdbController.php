<?php

namespace App\Http\Controllers\Main;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\SiswaBaru;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardPpdbController extends Controller
{
    protected $responseService;

    // Konstruktor untuk menginisialisasi ResponseService
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    // Menampilkan halaman index dashboard
    public function index()
    {
        // Mengembalikan tampilan index dashboard
        return view('main.dashboardppdb.views.index');
    }

    /**
     * Menampilkan laporan siswa baru berserta statusnya berdasarkan tahun akademik
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showReportOne()
    {
        try {
            // Mendapatkan tahun akademik aktif
            $activeAcademicYear = AppHelper::getActiveAcademicYear();

            if (!$activeAcademicYear) {
                return $this->responseService->errorResponse('Tahun akademik aktif tidak ditemukan.');
            }

            // Menghitung jumlah siswa baru dengan status 'mendaftar' berdasarkan tahun akademik
            $countMendaftar = SiswaBaru::where('tahun_akademik_id', $activeAcademicYear->id_tahun_akademik)
                ->count();

            // Menghitung jumlah siswa baru dengan status 'diterima' berdasarkan tahun akademik
            $countDiterima = SiswaBaru::where('tahun_akademik_id', $activeAcademicYear->id_tahun_akademik)
                ->where('status', 'diterima')
                ->count();

            // Menghitung jumlah siswa baru dengan status 'ditolak' berdasarkan tahun akademik
            $countDitolak = SiswaBaru::where('tahun_akademik_id', $activeAcademicYear->id_tahun_akademik)
                ->where('status', 'ditolak')
                ->count();

            // Menghitung jumlah siswa baru dengan status 'digenerate' berdasarkan tahun akademik
            $countDigenerate = SiswaBaru::where('tahun_akademik_id', $activeAcademicYear->id_tahun_akademik)
                ->where('status', 'digenerate')
                ->count();

            // Menghitung jumlah siswa baru yang belum diproses berdasarkan tahun akademik
            // Status yang null dianggap sebagai 'belum diproses'
            $countBelumDiproses = SiswaBaru::where('tahun_akademik_id', $activeAcademicYear->id_tahun_akademik)
                ->whereNull('status')  // Memeriksa apakah status null
                ->count();

            // Menentukan pesan jika tidak ada data
            $message = ($countMendaftar === 0 && $countDiterima === 0 && $countDitolak === 0 && $countBelumDiproses === 0)
                ? 'belum ada data' : 'data ditemukan';

            // Kembalikan response menggunakan responseService
            return $this->responseService->successResponse($message, null, [
                'count_mendaftar' => $countMendaftar,
                'count_diterima' => $countDiterima,
                'count_ditolak' => $countDitolak,
                'count_digenerate' => $countDigenerate,
                'count_belum_diproses' => $countBelumDiproses,
            ]);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil laporan: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil laporan', $e->getMessage());
        }
    }

    public function showReportTwo()
    {
        $pendaftarToday = SiswaBaru::getPendaftarToday();
        return $this->responseService->successResponse('Data ditemukan', $pendaftarToday, []);
    }

    public function showReportThree()
    {
        // Ambil data siswa yang sudah mendaftar dan gunakan usia saat mendaftar
        $siswaBaru = SiswaBaru::whereNotNull('usia_saat_mendaftar')->get();

        // Initialize data untuk rentang usia
        $usiaData = [
            '6-7' => 0,
            '7-8' => 0,
            '8-9' => 0,
            '9-10' => 0,
            '10-11' => 0,
            '11-12' => 0,
        ];

        // Proses data usia
        foreach ($siswaBaru as $siswa) {
            $usia = $siswa->usia_saat_mendaftar;

            // Kategorikan usia hanya dalam rentang 6-12 tahun
            if ($usia >= 6 && $usia <= 12) {
                if ($usia == 6 || $usia == 7) {
                    $usiaData['6-7']++;
                } elseif ($usia == 8 || $usia == 9) {
                    $usiaData['8-9']++;
                } elseif ($usia == 10 || $usia == 11) {
                    $usiaData['10-11']++;
                } elseif ($usia == 12) {
                    $usiaData['11-12']++;
                }
            }
        }

        // Hitung total siswa
        $totalSiswa = array_sum($usiaData);

        // Hitung persentase per kelompok usia
        $persentaseUsia = [];
        foreach ($usiaData as $key => $value) {
            $persentaseUsia[$key] = $totalSiswa > 0 ? round(($value / $totalSiswa) * 100, 2) : 0;
        }

        // Pastikan persentase semua kategori valid
        return $this->responseService->successResponse('Data ditemukan', $persentaseUsia, []);
    }
}
