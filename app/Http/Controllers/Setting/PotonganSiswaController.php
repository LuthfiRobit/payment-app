<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Potongan;
use App\Models\PotonganSiswa;
use App\Models\RincianTagihan;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TagihanSiswa;
use App\Models\TahunAkademik;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PotonganSiswaController extends Controller
{

    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index()
    {
        // $activeYear = AppHelper::getActiveAcademicYear();
        $potongan = Potongan::select('id_potongan', 'nama_potongan')->where('status', 'aktif')->get();
        $tahunAkademik = TahunAkademik::select('id_tahun_akademik', 'tahun', 'semester')->get()
            ->map(function ($q) {
                return [
                    'id_tahun_akademik' => $q->id_tahun_akademik,
                    'nama' => $q->tahun . ' - ' . $q->semester
                ];
            });
        return view('setting.potongan.views.index', compact('potongan', 'tahunAkademik'));
    }

    public function getData(Request $request)
    {
        // Menyiapkan filter dari request
        $filters = [
            'filter_kelas' => $request->input('filter_kelas', ''),
            'filter_potongan' => $request->input('filter_potongan', ''),
        ];

        // Mengambil data siswa beserta tagihan dan potongan dari model
        $query = Siswa::getSiswaWithPotongan($filters);

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($query)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm detail-button" title="Edit" data-id="' . $item->id_siswa . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->addColumn('tagihan', function ($row) {
                return $row->tagihan ?: 'Belum ada tagihan'; // Jika tidak ada tagihan, tampilkan "Belum ada tagihan"
            })
            ->addColumn('potongan', function ($row) {
                return $row->potongan ?: 'Belum ada potongan'; // Jika tidak ada potongan, tampilkan "Belum ada tagihan"
            })
            ->editColumn('nama_siswa', function ($item) {
                return strtoupper($item->nama_siswa);
            })
            ->editColumn('kelas', function ($item) {
                return strtoupper($item->kelas);
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id)
    {
        try {
            // Mencari siswa berdasarkan ID dan memuat relasi tagihanSiswa serta iuran
            $siswa = Siswa::with(['tagihanSiswa.iuran'])->find($id);

            // Jika data siswa tidak ditemukan
            if (!$siswa) {
                return $this->responseService->notFoundResponse('Data siswa tidak ditemukan');
            }

            // Mengambil data potongan yang aktif
            $potongan = Potongan::select('id_potongan', 'nama_potongan')->where('status', 'aktif')->get();

            // Jika data ditemukan
            return $this->responseService->successResponse('Data siswa berhasil ditemukan', $siswa, [
                'potongan' => $potongan, // Tambahkan kunci tambahan sesuai kebutuhan
            ]);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil data siswa: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil data siswa', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // Mulai transaksi database untuk memastikan konsistensi data
        DB::beginTransaction();

        try {
            // Validasi input
            $request->validate([
                'siswa_id' => 'required|uuid|exists:siswa,id_siswa',
                'tagihan_siswa_id' => 'required|array',
                'tagihan_siswa_id.*' => 'uuid|exists:tagihan_siswa,id_tagihan_siswa',
                'jenis_potongan' => 'nullable|array',
                'jenis_potongan.*' => 'nullable|uuid|exists:potongan,id_potongan',
                'potongan_persen' => 'nullable|array',
                'potongan_persen.*' => 'nullable|integer|min:1|max:100',
                'besar_iuran' => 'required|array',
                'besar_iuran.*' => 'required|integer|min:0',
            ], [
                'siswa_id.required' => 'Siswa ID wajib diisi.',
                'siswa_id.exists' => 'Siswa tidak ditemukan.',
                'tagihan_siswa_id.required' => 'Tagihan siswa wajib diisi.',
                'tagihan_siswa_id.*.exists' => 'Tagihan siswa tidak ditemukan.',
                'jenis_potongan.*.exists' => 'Jenis potongan tidak ditemukan.',
                'potongan_persen.*.min' => 'Persentase potongan minimal 1%.',
                'potongan_persen.*.max' => 'Persentase potongan maksimal 100%.',
                'besar_iuran.*.min' => 'Besar iuran minimal 0.',
            ]);

            // Ambil data dari request
            $siswaId = $request->siswa_id;
            $tagihanSiswaIds = $request->tagihan_siswa_id;
            $jenisPotongan = $request->jenis_potongan ?? []; // Jika tidak ada, default array kosong
            $potonganPersen = $request->potongan_persen ?? [];

            // Iterasi setiap tagihan_siswa_id untuk menyimpan potongan dan rincian tagihan
            foreach ($tagihanSiswaIds as $index => $tagihanSiswaId) {

                // Periksa apakah ada potongan yang dipilih untuk tagihan ini
                if (isset($jenisPotongan[$index]) && !empty($jenisPotongan[$index])) {
                    // Hitung besar potongan berdasarkan persentase yang diberikan
                    $currentPotonganPersen = $potonganPersen[$index] ?? 0;

                    // Simpan data potongan_siswa
                    PotonganSiswa::create([
                        'id_potongan_siswa' => Str::uuid(),
                        'siswa_id' => $siswaId,
                        'tagihan_siswa_id' => $tagihanSiswaId,
                        'potongan_id' => $jenisPotongan[$index],
                        'potongan_persen' => $currentPotonganPersen,
                        'status' => 'aktif',
                    ]);
                }
            }

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            // Kembalikan respon sukses
            return $this->responseService->successResponse('Potongan berhasil ditambahkan untuk siswa dan iuran terpilih!', [], []);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Log kesalahan untuk debugging
            Log::error('Error saat menyimpan tagihan massal: ' . $e->getMessage());

            // Kembalikan respon error
            return $this->responseService->errorResponse('Terjadi kesalahan saat menambahkan tagihan.', $e->getMessage());
        }
    }
}
