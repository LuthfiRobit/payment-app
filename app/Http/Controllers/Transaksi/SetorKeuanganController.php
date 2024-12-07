<?php

namespace App\Http\Controllers\Transaksi;

use App\Exports\SetoranExport;
use App\Http\Controllers\Controller;
use App\Models\RincianSetoran;
use App\Models\RincianTransaksi;
use App\Models\SetoranKeuangan;
use App\Models\TahunAkademik;
use App\Models\Transaksi;
use App\Services\ResponseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SetorKeuanganController extends Controller
{

    protected $responseService;

    /**
     * Konstruktor untuk menginisialisasi ResponseService.
     *
     * @param \App\Services\ResponseService $responseService
     */
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    /**
     * Menampilkan halaman index setor.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $years = range($currentYear - 3, $currentYear + 3);

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return view('transaksi.setor.views.index', compact('years', 'months'));
    }

    /**
     * Mengambil data setoran keuangan dengan filter.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        $filters = [
            'filter_tahun' => $request->input('filter_tahun', ''),
            'filter_bulan' => $request->input('filter_bulan', ''),
            'filter_status' => $request->input('filter_status', ''),
        ];

        $query = SetoranKeuangan::getSetoranWithFilters($filters);

        return DataTables::of($query)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-info btn-sm detail-button" title="Detail" data-id="' . $item->id_setoran_keuangan . '">
                    <i class="bi bi-info-circle"></i>
                </button>';
            })
            ->addColumn('tahun_bulan', function ($item) {
                return strtoupper($item->nama_bulan . ' - ' . $item->tahun);
            })
            ->editColumn('total_bayar', function ($item) {
                return Number::currency($item->total_bayar, 'IDR', 'id');
            })
            ->editColumn('total_setoran', function ($item) {
                return Number::currency($item->total_setoran, 'IDR', 'id');
            })
            ->editColumn('sisa_setoran', function ($item) {
                return Number::currency($item->sisa_setoran, 'IDR', 'id');
            })
            ->editColumn('tanggal_setoran', function ($item) {
                return \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y');
            })
            ->editColumn('status', function ($item) {
                $badgeClass = ($item->status == 'lunas') ? 'light badge-primary' : 'light badge-danger';
                return '<span class="fs-7 badge ' . $badgeClass . '">' . strtoupper($item->status) . '</span>';
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function show($id)
    {
        try {
            $setoranKeuangan = SetoranKeuangan::where('id_setoran_keuangan', $id)->first();

            if (!$setoranKeuangan) {
                return $this->responseService->notFoundResponse('Data setoran tidak ditemukan');
            }

            $rincianSetoran = RincianSetoran::getByIdSetoran($id);

            $data = [
                'setoran_keuangan' => $setoranKeuangan,
                'rincian_setoran' => $rincianSetoran,
            ];

            return $this->responseService->successResponse('Data setoran berhasil ditemukan', $data, []);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil data setoran: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil data setoran', $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman form untuk membuat setoran keuangan baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $currentYear = Carbon::now()->year;
        $years = range($currentYear - 3, $currentYear + 3);

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return view('transaksi.setor.views.create', compact('years', 'months'));
    }

    /**
     * Mencari data transaksi dan rincian transaksi berdasarkan filter.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Request $request)
    {
        $filters = [
            'filter_tahun' => $request->input('filter_tahun', date('Y')),
            'filter_bulan' => $request->input('filter_bulan', date('m')),
        ];

        try {
            $transaksi = Transaksi::getTransaksiSetoran($filters);

            if (!$transaksi) {
                return $this->responseService->notFoundResponse('Data transaksi tidak ditemukan');
            }

            $rincianTransaksi = RincianTransaksi::getRincianTransaksiSetoran($filters);

            $data = [
                'transaksi' => $transaksi,
                'rincian_transaksi' => $rincianTransaksi,
            ];

            return $this->responseService->successResponse('Data tagihan berhasil ditemukan', $data, []);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data transaksi: ' . $e->getMessage());

            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data transaksi',
                'error' => 'Kesalahan server'
            ], 500);
        }
    }

    /**
     * Menyimpan data setoran keuangan setelah validasi dan pemrosesan detail setoran.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        DB::beginTransaction();

        try {
            $setoranKeuangan = $this->createOrUpdateSetoranKeuangan($request);

            list($totalTagihan, $totalSetoran, $totalSisa, $allLunas) = $this->initializeCounters();

            foreach ($request->setoran_details as $detail) {
                $this->processSetoranDetail($setoranKeuangan, $detail, $totalTagihan, $totalSetoran, $totalSisa, $allLunas);
            }

            $this->updateSetoranKeuanganStatus($setoranKeuangan, $totalTagihan, $totalSetoran, $totalSisa, $allLunas);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Setoran berhasil disimpan.',
                'data' => $setoranKeuangan,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan, silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function export(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'tahun' => 'required|date_format:Y',
                'bulan' => 'required|date_format:m',
            ]);

            // Prepare export data
            $tahun = $request->input('tahun');
            $bulan = $request->input('bulan');

            // Prepare file name
            $fileName = 'setoran_bulan_' . $bulan . '_' . $tahun . '.xlsx';

            // Download the file using Laravel Excel
            return Excel::download(new SetoranExport($tahun, $bulan), $fileName);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error saat export setoran: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'tahun' => $request->input('tahun'),
                'bulan' => $request->input('bulan'),
            ]);

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengekspor data setoran.',
                'error' => $e->getMessage(),
            ], 500); // Internal Server Error
        }
    }

    /**
     * Return validation rules for the request.
     */
    private function validationRules()
    {
        return [
            'tahun' => 'required|integer|between:2000,2099',
            'bulan' => 'required|integer|between:1,12',
            'nama_bulan' => 'required|string|max:255',
            'setoran_details' => 'required|array',
            'setoran_details.*.iuran_id' => 'required|exists:iuran,id_iuran',
            'setoran_details.*.total_tagihan_setoran' => 'required|integer|min:0',
            'setoran_details.*.total_setoran' => 'required|integer|min:0',
            'setoran_details.*.sisa_setoran' => 'required|integer|min:0',
            'setoran_details.*.status' => 'required|in:lunas,belum lunas',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Create or update a setoran keuangan entry.
     */
    private function createOrUpdateSetoranKeuangan(Request $request)
    {
        return SetoranKeuangan::updateOrCreate(
            [
                'tahun' => $request->tahun,
                'bulan' => $request->bulan,
            ],
            [
                'nama_bulan' => $request->nama_bulan,
                'total_tagihan_setoran' => 0,
                'total_setoran' => 0,
                'sisa_setoran' => 0,
                'keterangan' => $request->keterangan,
                'status' => 'belum lunas',
            ]
        );
    }

    /**
     * Initialize the counters for total calculations.
     */
    private function initializeCounters()
    {
        return [0, 0, 0, true];
    }

    /**
     * Process each setoran detail, updating totals and status.
     */
    private function processSetoranDetail($setoranKeuangan, $detail, &$totalTagihan, &$totalSetoran, &$totalSisa, &$allLunas)
    {
        // Update totals
        $totalTagihan += $detail['total_tagihan_setoran'];
        $totalSisa += $detail['sisa_setoran'];

        // Determine the status of the detail
        $statusRincian = $this->determineStatus($detail);

        // Check for existing rincian setoran
        $existingRincianSetoran = $this->findExistingRincianSetoran($setoranKeuangan, $detail['iuran_id']);

        // Calculate new total setoran
        $newTotalSetoran = $this->calculateNewTotalSetoran($existingRincianSetoran, $detail);

        // Update or create rincian setoran
        $this->updateOrCreateRincianSetoran($setoranKeuangan, $detail, $newTotalSetoran, $statusRincian);

        // Update total setoran and check if all are lunas
        $totalSetoran += $newTotalSetoran;
        if ($statusRincian !== 'lunas') {
            $allLunas = false;
        }
    }

    /**
     * Determine the status of a setoran detail.
     */
    private function determineStatus($detail)
    {
        return $detail['status'] === 'lunas' && $detail['sisa_setoran'] == 0 ? 'lunas' : 'belum lunas';
    }

    /**
     * Find an existing rincian setoran for the given iuran_id.
     */
    private function findExistingRincianSetoran($setoranKeuangan, $iuranId)
    {
        return RincianSetoran::where('setoran_keuangan_id', $setoranKeuangan->id_setoran_keuangan)
            ->where('iuran_id', $iuranId)
            ->first();
    }

    /**
     * Calculate the new total setoran, considering previous contributions.
     */
    private function calculateNewTotalSetoran($existingRincianSetoran, $detail)
    {
        if ($existingRincianSetoran && $existingRincianSetoran->status === 'belum lunas') {
            return $existingRincianSetoran->total_setoran + $detail['total_setoran'];
        }

        return $detail['total_setoran'];
    }

    /**
     * Update or create a rincian setoran entry.
     */
    private function updateOrCreateRincianSetoran($setoranKeuangan, $detail, $newTotalSetoran, $statusRincian)
    {
        RincianSetoran::updateOrCreate(
            [
                'setoran_keuangan_id' => $setoranKeuangan->id_setoran_keuangan,
                'iuran_id' => $detail['iuran_id'],
            ],
            [
                'total_tagihan_setoran' => $detail['total_tagihan_setoran'],
                'total_setoran' => $newTotalSetoran,
                'sisa_setoran' => $detail['sisa_setoran'],
                'status' => $statusRincian,
            ]
        );
    }

    /**
     * Update the setoran keuangan status after all details are processed.
     */
    private function updateSetoranKeuanganStatus($setoranKeuangan, $totalTagihan, $totalSetoran, $totalSisa, $allLunas)
    {
        $setoranKeuangan->update([
            'total_tagihan_setoran' => $totalTagihan,
            'total_setoran' => $totalSetoran,  // Updated with total setoran after processing all details
            'sisa_setoran' => $totalSisa,
            'status' => $allLunas || $totalSisa == 0 ? 'lunas' : 'belum lunas',
        ]);
    }
}
