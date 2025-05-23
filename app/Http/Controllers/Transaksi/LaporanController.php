<?php

namespace App\Http\Controllers\Transaksi;

use App\Exports\TransaksiExport;
use App\Http\Controllers\Controller;
use App\Models\RincianTransaksi;
use App\Models\Siswa;
use App\Models\TahunAkademik;
use App\Models\Transaksi;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    protected $responseService;

    // Konstruktor untuk menginisialisasi ResponseService
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    // Menampilkan halaman index laporan
    public function index()
    {
        // Mengambil data tahun akademik
        $tahunAkademik = TahunAkademik::select('id_tahun_akademik', 'tahun', 'semester')->get();

        // Mengembalikan tampilan index laporan dengan data tahun akademik
        return view('transaksi.laporan.views.index', compact('tahunAkademik'));
    }

    public function getData(Request $request)
    {
        // Get the currently authenticated user
        $authUser = auth()->user();

        // Menyiapkan filter dari request
        $filters = [
            'filter_petugas' => $authUser->role == 'petugas_pembayaran' ? $authUser->id_user : '',
            'filter_tahun' => $request->input('filter_tahun', ''), // Filter untuk tahun akademik
            'filter_siswa' => $request->input('filter_siswa', ''), // Filter untuk ID siswa
            'filter_tanggal' => $request->input('filter_tanggal', ''), // Filter untuk tanggal bayar
        ];

        // Mengambil data transaksi dengan filter yang ditentukan
        $query = Transaksi::getTransaksiWithFilters($filters);

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($query)
            ->addColumn('aksi', function ($item) {
                // Tombol untuk aksi detail
                return '<button class="btn btn-outline-info btn-sm detail-button" title="Detail" data-id="' . $item->id_transaksi . '">
                <i class="bi bi-info-circle"></i>
            </button>';
            })
            ->addColumn('nomor_transaksi', function ($item) {
                // Mengubah nomor transaksi menjadi uppercase
                return strtoupper($item->nomor_transaksi);
            })
            ->addColumn('tahun_akademik', function ($item) {
                // Mengubah tahun dan semester menjadi uppercase
                return strtoupper($item->tahun . ' - ' . $item->semester);
            })
            ->addColumn('siswa', function ($item) {
                // Mengubah NIS dan nama siswa menjadi uppercase
                return strtoupper($item->nis . ' - ' . $item->nama_siswa);
            })
            ->editColumn('jumlah_bayar', function ($item) {
                // Format jumlah bayar menjadi mata uang
                return Number::currency($item->jumlah_bayar, 'IDR', 'id');
            })
            ->editColumn('tanggal_bayar', function ($item) {
                // Mengubah format tanggal bayar menjadi "14 Agustus 2024" dengan locale Indonesia
                return \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d F Y');
            })
            ->editColumn('creator_nama', function ($item) {
                if ($item->creator_nama) {
                    return $item->creator_nama;
                }
                return '-';
            })
            ->editColumn('status', function ($item) {
                // Menampilkan status dalam bentuk badge dengan warna sesuai status
                $badgeClass = ($item->status == 'sukses') ? 'light badge-primary' : 'light badge-danger';
                return '<span class="fs-7 badge ' . $badgeClass . '">' . strtoupper($item->status) . '</span>';
            })
            ->rawColumns(['aksi', 'status']) // Menandai kolom yang dapat berisi HTML
            ->make(true); // Mengembalikan response DataTables
    }

    public function show($id)
    {
        try {
            // Mencari data transaksi berdasarkan ID yang diberikan
            $transaksi = Transaksi::select(
                'transaksi.id_transaksi',
                'transaksi.nomor_transaksi',
                'transaksi.siswa_id',
                'transaksi.jumlah_bayar',
                'transaksi.tanggal_bayar',
                'transaksi.status',
                'creator.name as creator_nama',
            )->leftJoin('users as creator', 'creator.id_user', '=', 'transaksi.created_by')->find($id);

            // Jika data transaksi tidak ditemukan, kembalikan response 404
            if (!$transaksi) {
                return $this->responseService->notFoundResponse('Data transaksi tidak ditemukan');
            }

            // Mengambil data siswa berdasarkan ID siswa yang terdapat di dalam transaksi
            $siswa = Siswa::where('id_siswa', $transaksi->siswa_id)->select('id_siswa', 'nis', 'nama_siswa', 'kelas', 'nomor_telepon')->first();

            // Mengambil rincian transaksi menggunakan metode yang sudah didefinisikan sebelumnya
            $rincianTransaksi = RincianTransaksi::getDataByIdTransaksi($id);

            // Jika data transaksi ditemukan, kembalikan response sukses dengan data transaksi, siswa, dan rincian
            return $this->responseService->successResponse('Data transaksi berhasil ditemukan', $transaksi, [
                'siswa' => $siswa,
                'rincian' => $rincianTransaksi // Menambahkan rincian transaksi ke dalam response
            ]);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil data transaksi: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil data transaksi', $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'tahun_akademik_id' => 'required|exists:tahun_akademik,id_tahun_akademik',
                'bulan' => 'required|date_format:m',
            ]);

            // Prepare export data
            $tahunAkademikId = $request->input('tahun_akademik_id');
            $bulan = $request->input('bulan');

            // Prepare file name
            $fileName = 'transaksi_bulan_' . $bulan . '.xlsx';

            // Download the file using Laravel Excel
            return Excel::download(new TransaksiExport($tahunAkademikId, $bulan), $fileName);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error saat export transaksi: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'tahun_akademik_id' => $request->input('tahun_akademik_id'),
                'bulan' => $request->input('bulan'),
            ]);

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengekspor data transaksi.',
                'error' => $e->getMessage(),
            ], 500); // Internal Server Error
        }
    }
}
