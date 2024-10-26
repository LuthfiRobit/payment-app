<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TahunAkademikController extends Controller
{
    public function index()
    {
        return view('master.tahunAkademik.views.index');
    }

    public function getData(Request $request)
    {
        $query = TahunAkademik::select('id_tahun_akademik', 'tahun', 'semester', 'status')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        $result = $query->get();

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_tahun_akademik . '">
                <i class="fas fa-edit"></i>
            </button>';
            })
            ->editColumn('tahun', function ($item) {
                return $item->tahun;
            })
            ->editColumn('semester', function ($item) {
                return strtoupper($item->semester); // Mengubah semester menjadi kapital
            })
            ->editColumn('status', function ($item) {
                $checked = ($item->status == 'aktif') ? 'checked disabled' : '';
                $label = ($item->status == 'aktif') ? 'Aktif' : 'Tidak Aktif';

                return '<div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="switch_' . $item->id_tahun_akademik . '" ' . $checked . ' data-id="' . $item->id_tahun_akademik . '">
                            <label class="form-check-label" for="switch_' . $item->id_tahun_akademik . '">' . $label . '</label>
                        </div>';
            })
            ->rawColumns(['aksi', 'status']) // Tambahkan status agar HTML bisa dirender
            ->make(true);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tahun' => 'required|regex:/^\d{4}\/\d{4}$/',
            'semester' => 'required|in:ganjil,genap',
            // 'status' => 'required|in:aktif,tidak aktif', // Tanda underscore di sini
        ]);

        try {
            // Cek apakah kombinasi tahun dan semester sudah ada
            $existing = TahunAkademik::where('tahun', $request->tahun)
                ->where('semester', $request->semester)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun akademik ini sudah ada untuk semester ' . $request->semester . '.',
                ], 409); // 409 Conflict
            }

            // Simpan data tahun akademik baru
            $tahunAkademik = new TahunAkademik();
            $tahunAkademik->id_tahun_akademik = Str::uuid(); // Menggunakan UUID
            $tahunAkademik->tahun = $request->tahun;
            $tahunAkademik->semester = $request->semester;
            $tahunAkademik->status = 'tidak aktif';
            // $tahunAkademik->created_at = now();
            // $tahunAkademik->updated_at = now();
            $tahunAkademik->save();

            return response()->json([
                'success' => true,
                'message' => 'Tahun Akademik berhasil ditambahkan.',
                'data' => $tahunAkademik,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan tahun akademik: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan tahun akademik.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = TahunAkademik::find($id);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data tahun akademik: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tahun' => 'required|regex:/^\d{4}\/\d{4}$/',
            'semester' => 'required|in:ganjil,genap',
            // 'status' => 'required|in:aktif,tidak aktif',
        ]);

        try {
            // Cari data tahun akademik berdasarkan ID
            $tahunAkademik = TahunAkademik::find($id);

            if (!$tahunAkademik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun Akademik tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            // Cek apakah kombinasi tahun dan semester sudah ada untuk entry lain
            $existing = TahunAkademik::where('tahun', $request->tahun)
                ->where('semester', $request->semester)
                ->where('id_tahun_akademik', '!=', $id) // Pastikan tidak mengecek entry yang sedang diupdate
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun akademik ini sudah ada untuk semester ' . $request->semester . '.',
                ], 409); // 409 Conflict
            }

            // Update data tahun akademik
            $tahunAkademik->tahun = $request->tahun;
            $tahunAkademik->semester = $request->semester;
            // $tahunAkademik->status = $request->status;
            $tahunAkademik->save();

            return response()->json([
                'success' => true,
                'message' => 'Tahun Akademik berhasil diperbarui.',
                'data' => $tahunAkademik,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui tahun akademik: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui tahun akademik.',
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:tahun_akademik,id_tahun_akademik',
        ]);

        try {
            // Nonaktifkan semua tahun akademik
            TahunAkademik::query()->update(['status' => 'tidak aktif']);

            // Aktifkan tahun akademik yang dipilih
            $tahunAkademik = TahunAkademik::find($validatedData['id']);
            $tahunAkademik->status = 'aktif';
            $tahunAkademik->save();

            return response()->json([
                'success' => true,
                'message' => 'Tahun akademik berhasil diaktifkan.',
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat mengubah status tahun akademik: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status tahun akademik.',
            ], 500);
        }
    }
}
