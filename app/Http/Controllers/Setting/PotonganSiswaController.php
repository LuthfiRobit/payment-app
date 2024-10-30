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
            $siswa = Siswa::with(['tagihanSiswa.iuran', 'potonganSiswa.potongan'])->find($id);

            if (!$siswa) {
                return $this->responseService->notFoundResponse('Data siswa tidak ditemukan');
            }

            // Ambil hanya tagihan yang aktif
            $tagihan_siswa = $siswa->tagihanSiswa->filter(function ($tagihan) {
                return $tagihan->status === 'aktif';
            })->map(function ($tagihan) use ($siswa) {
                // Ambil potongan yang berelasi dengan tagihan
                $potongan_siswa = $siswa->potonganSiswa->where('tagihan_siswa_id', $tagihan->id_tagihan_siswa);

                return [
                    'id_tagihan_siswa' => $tagihan->id_tagihan_siswa,
                    'iuran' => [
                        'id_iuran' => $tagihan->iuran->id_iuran,
                        'nama_iuran' => $tagihan->iuran->nama_iuran,
                        'besar_iuran' => $tagihan->iuran->besar_iuran,
                    ],
                    'potongan_siswa' => $potongan_siswa->map(function ($potongan) {
                        return [
                            'id_potongan_siswa' => $potongan->id_potongan_siswa,
                            'potongan_id' => $potongan->potongan_id,
                            'potongan_persen' => $potongan->potongan_persen,
                            'status' => $potongan->status,
                            'potongan' => [
                                'id_potongan' => $potongan->potongan->id_potongan,
                                'nama_potongan' => $potongan->potongan->nama_potongan,
                                // Menghilangkan created_at dan updated_at
                            ]
                        ];
                    })->values() // memastikan hasilnya adalah array terindeks
                ];
            });

            $potongan = Potongan::select('id_potongan', 'nama_potongan')->where('status', 'aktif')->get();

            return $this->responseService->successResponse('Data siswa berhasil ditemukan', [
                'id_siswa' => $siswa->id_siswa,
                'nis' => $siswa->nis,
                'nama_siswa' => $siswa->nama_siswa,
                'status' => $siswa->status,
                'kelas' => $siswa->kelas,
                'tagihan_siswa' => $tagihan_siswa,
            ], ['potongan' => $potongan]);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data siswa: ' . $e->getMessage());
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil data siswa', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi input dengan pesan khusus untuk setiap aturan
            $request->validate([
                'siswa_id' => 'required|uuid|exists:siswa,id_siswa',
                'tagihan_siswa_id' => 'required|array',
                'tagihan_siswa_id.*' => 'uuid|exists:tagihan_siswa,id_tagihan_siswa',
                'potongan_id' => 'nullable|array',
                'potongan_id.*' => 'nullable|uuid|exists:potongan,id_potongan',
                'potongan_persen' => 'nullable|array',
                'potongan_persen.*' => 'nullable|integer|min:1|max:100',
            ], [
                'siswa_id.required' => 'Siswa ID wajib diisi.',
                'siswa_id.exists' => 'Siswa tidak ditemukan.',
                'tagihan_siswa_id.required' => 'Tagihan siswa wajib diisi.',
                'tagihan_siswa_id.*.exists' => 'Tagihan siswa tidak valid.',
                'potongan_id.*.exists' => 'Jenis potongan tidak valid.',
            ]);

            // Mengambil data input dari request
            $siswaId = $request->input('siswa_id');
            $tagihanSiswaIds = $request->input('tagihan_siswa_id');
            $potonganIds = $request->input('potongan_id', []);
            $potonganPersen = $request->input('potongan_persen', []);

            // Looping setiap tagihan siswa
            foreach ($tagihanSiswaIds as $index => $tagihanSiswaId) {
                $potonganId = $potonganIds[$index] ?? null;
                $persen = $potonganPersen[$index] ?? null;

                if ($potonganId && $persen) {
                    // Jika potongan dipilih dan ada persentase, periksa apakah data sudah ada
                    $this->upsertPotonganSiswa($siswaId, $tagihanSiswaId, $potonganId, $persen);
                } else {
                    // Jika potongan tidak dipilih atau persen kosong, nonaktifkan potongan jika ada
                    $this->deactivatePotonganSiswa($siswaId, $tagihanSiswaId, $potonganId);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Potongan berhasil disimpan atau diperbarui.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan potongan: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan potongan.'], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id_potongan_siswa' => 'required|exists:potongan_siswa,id_potongan_siswa',
            'potongan_id' => 'required|exists:potongan_siswa,potongan_id',
        ]);

        try {
            // Find and deactivate the specific discount
            $potongan = PotonganSiswa::where('id_potongan_siswa', $validatedData['id_potongan_siswa'])
                ->where('potongan_id', $validatedData['potongan_id'])
                ->first();

            if ($potongan) {
                $potongan->status = 'tidak aktif';
                $potongan->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Potongan berhasil dinonaktifkan.',
                ], 200); // HTTP 200 OK
            }

            return response()->json([
                'success' => false,
                'message' => 'Potongan tidak ditemukan.',
            ], 404); // HTTP 404 Not Found

        } catch (\Exception $e) {
            Log::error('Error saat menonaktifkan potongan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menonaktifkan potongan.',
            ], 500); // HTTP 500 Internal Server Error
        }
    }

    /**
     * Upsert (insert or update) data potongan siswa.
     *
     * @param string $siswaId ID Siswa
     * @param string $tagihanSiswaId ID Tagihan Siswa
     * @param string $potonganId ID Potongan
     * @param int $persen Persentase Potongan
     */
    private function upsertPotonganSiswa($siswaId, $tagihanSiswaId, $potonganId, $persen)
    {
        // Periksa apakah data potongan siswa sudah ada
        $existingPotongan = PotonganSiswa::where([
            'siswa_id' => $siswaId,
            'tagihan_siswa_id' => $tagihanSiswaId,
            'potongan_id' => $potonganId,
        ])->first();

        if ($existingPotongan) {
            // Jika data ada, update persentase dan status
            $existingPotongan->update([
                'potongan_persen' => $persen,
                'status' => 'aktif',
            ]);
        } else {
            // Jika data belum ada, buat entri baru
            PotonganSiswa::create([
                'siswa_id' => $siswaId,
                'tagihan_siswa_id' => $tagihanSiswaId,
                'potongan_id' => $potonganId,
                'potongan_persen' => $persen,
                'status' => 'aktif',
            ]);
        }
    }

    /**
     * Nonaktifkan potongan siswa jika ada.
     *
     * @param string $siswaId ID Siswa
     * @param string $tagihanSiswaId ID Tagihan Siswa
     * @param string|null $potonganId ID Potongan, bisa null
     */
    private function deactivatePotonganSiswa($siswaId, $tagihanSiswaId, $potonganId)
    {
        // Update status potongan menjadi tidak aktif jika data ada
        PotonganSiswa::where([
            'siswa_id' => $siswaId,
            'tagihan_siswa_id' => $tagihanSiswaId,
            'potongan_id' => $potonganId,
        ])->update(['status' => 'tidak aktif']);
    }
}
