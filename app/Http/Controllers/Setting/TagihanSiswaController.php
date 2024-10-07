<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Iuran;
use App\Models\Siswa;
use App\Models\TagihanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class TagihanSiswaController extends Controller
{
    public function index()
    {
        $iuran = Iuran::select('id_iuran', 'nama_iuran', 'besar_iuran')->where('status', 'aktif')->get();
        return view('setting.tagihan.views.index', compact('iuran'));
    }

    public function getData(Request $request)
    {
        // Menyiapkan filter dari request
        $filters = [
            'filter_status' => $request->input('filter_status', ''),
            'filter_kelas' => $request->input('filter_kelas', ''),
        ];

        // Mengambil data siswa beserta tagihan sekaligus dalam satu query menggunakan join
        $siswaData = DB::table('siswa')
            ->leftJoin('tagihan_siswa', 'siswa.id_siswa', '=', 'tagihan_siswa.siswa_id')
            ->leftJoin('iuran', 'tagihan_siswa.iuran_id', '=', 'iuran.id_iuran')
            ->select(
                'siswa.id_siswa',
                'siswa.nis',
                'siswa.nama_siswa',
                'siswa.kelas',
                'siswa.status',
                DB::raw('GROUP_CONCAT(iuran.nama_iuran SEPARATOR ", ") as tagihan') // Menggabungkan tagihan dalam satu kolom
            )
            ->groupBy('siswa.id_siswa', 'siswa.nis', 'siswa.nama_siswa', 'siswa.kelas', 'siswa.status');

        // Filter berdasarkan status atau kelas jika ada
        if (!empty($filters['filter_status'])) {
            $siswaData->where('siswa.status', $filters['filter_status']);
        }

        if (!empty($filters['filter_kelas'])) {
            $siswaData->where('siswa.kelas', $filters['filter_kelas']);
        }

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($siswaData)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="siswa-checkbox form-check-input" value="' . $row->id_siswa . '">';
            })
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm detail-button" title="Edit" data-id="' . $item->id_siswa . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->addColumn('tagihan', function ($row) {
                return $row->tagihan ?: 'Belum ada tagihan'; // Jika tidak ada tagihan, tampilkan "Belum ada tagihan"
            })
            ->editColumn('nama_siswa', function ($item) {
                return strtoupper($item->nama_siswa);
            })
            ->editColumn('kelas', function ($item) {
                return strtoupper($item->kelas);
            })
            ->editColumn('status', function ($item) {
                // Menampilkan status dalam bentuk badge dan kapital
                $badgeClass = ($item->status == 'aktif') ? 'light badge-primary' : 'light badge-danger';
                return '<span class="fs-7 badge ' . $badgeClass . '">' . strtoupper($item->status) . '</span>';
            })
            ->rawColumns(['checkbox', 'aksi', 'status'])
            ->make(true);
    }


    public function show($id)
    {
        try {
            // Mencari siswa berdasarkan ID dan memuat relasi tagihanSiswa serta iuran
            $siswa = Siswa::with('tagihanSiswa.iuran')->find($id);

            // Jika data siswa tidak ditemukan
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data siswa tidak ditemukan',
                ], 404);
            }

            // Jika data ditemukan
            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil ditemukan',
                'data' => $siswa
            ], 200);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil data siswa: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data siswa',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request) {}

    // public function storeMultiple(Request $request)
    // {
    //     // Logika untuk set tagihan massal
    //     $siswa_ids = $request->siswa_ids;
    //     $iuran_id = $request->iuran_id;

    //     foreach ($siswa_ids as $siswa_id) {
    //         TagihanSiswa::create([
    //             'siswa_id' => $siswa_id,
    //             'iuran_id' => $iuran_id,
    //             'status' => 'aktif',
    //         ]);
    //     }

    //     return response()->json(['success' => 'Tagihan berhasil ditambahkan untuk siswa terpilih!']);
    // }

    public function storeMultiple(Request $request)
    {
        try {
            // Validasi inputan yang masuk
            $validatedData = $request->validate([
                'siswa_ids' => 'required|array',
                'siswa_ids.*' => 'exists:siswa,id_siswa', // Setiap siswa_id harus ada di tabel siswa
                'iuran_ids' => 'required|array', // Mendukung banyak iuran
                'iuran_ids.*' => 'exists:iuran,id_iuran', // Setiap iuran_id harus valid di tabel iuran
            ]);

            // Ambil data dari request
            $siswa_ids = $validatedData['siswa_ids'];
            $iuran_ids = $validatedData['iuran_ids'];

            // Looping untuk setiap siswa yang dipilih
            foreach ($siswa_ids as $siswa_id) {
                // Looping untuk setiap iuran yang dipilih
                foreach ($iuran_ids as $iuran_id) {
                    // Pastikan tidak ada duplikasi tagihan
                    TagihanSiswa::firstOrCreate([
                        'siswa_id' => $siswa_id,
                        'iuran_id' => $iuran_id,
                    ], [
                        'status' => 'aktif',
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Tagihan berhasil ditambahkan untuk siswa dan iuran terpilih!'
            ], 200);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error saat menyimpan tagihan massal: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan tagihan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
