<?php

namespace App\Http\Controllers\Tagihan;

use App\Http\Controllers\Controller;
use App\Models\RincianTagihan;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class DaftarTagihanController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index()
    {
        return view('tagihan.daftar.views.index');
    }

    public function getData(Request $request)
    {
        // Menyiapkan filter dari request
        $filters = [
            'filter_kelas' => $request->input('filter_kelas', ''),
            'filter_status' => $request->input('filter_status', ''),
        ];

        // Mengambil data siswa beserta tagihan dan potongan dari model
        $query = Tagihan::tagihanByTa($filters);

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($query)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm detail-button" title="Edit" data-id="' . $item->id_tagihan . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->addColumn('tahun_akademik', function ($item) {
                return strtoupper($item->tahun . ' - ' . $item->semester); // Mengubah NIS dan nama siswa menjadi uppercase
            })
            ->addColumn('siswa', function ($item) {
                return strtoupper($item->nis . ' - ' . $item->nama_siswa); // Mengubah NIS dan nama siswa menjadi uppercase
            })
            ->addColumn('kelas', function ($item) {
                return strtoupper($item->kelas); // Mengubah kelas menjadi uppercase
            })
            ->editColumn('besar_tagihan', function ($item) {
                return Number::currency($item->besar_tagihan, 'IDR', 'id');
            })
            ->editColumn('besar_potongan', function ($item) {
                return Number::currency($item->besar_potongan, 'IDR', 'id');
            })
            ->editColumn('total_tagihan', function ($item) {
                return Number::currency($item->total_tagihan, 'IDR', 'id');
            })
            ->editColumn('status', function ($item) {
                // Menampilkan status dalam bentuk badge dan kapital
                $badgeClass = ($item->status == 'lunas') ? 'light badge-primary' : 'light badge-danger';
                return '<span class="fs-7 badge ' . $badgeClass . '">' . strtoupper($item->status) . '</span>';
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function show($id)
    {
        try {
            // Mencari data tagihan berdasarkan ID yang diberikan
            $tagihan = Tagihan::find($id);

            // Jika data tagihan tidak ditemukan, kembalikan response 404
            if (!$tagihan) {
                return $this->responseService->notFoundResponse('Data tagihan tidak ditemukan');
            }

            // Mengambil data siswa berdasarkan ID siswa yang terdapat di dalam tagihan
            $siswa = Siswa::where('id_siswa', $tagihan->siswa_id)->select('id_siswa', 'nis', 'nama_siswa', 'kelas', 'nomor_telepon')->first();

            // Mengambil rincian tagihan menggunakan metode yang sudah didefinisikan sebelumnya
            $rincianTagihan = RincianTagihan::getByTagihan($id);

            // Jika data tagihan ditemukan, kembalikan response sukses dengan data tagihan, siswa, dan rincian
            return $this->responseService->successResponse('Data tagihan berhasil ditemukan', $tagihan, [
                'siswa' => $siswa,
                'rincian' => $rincianTagihan // Menambahkan rincian tagihan ke dalam response
            ]);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil data tagihan: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil data tagihan', $e->getMessage());
        }
    }
}
