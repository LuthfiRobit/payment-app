<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Iuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class IuranController extends Controller
{
    public function index()
    {
        return view('master.iuran.views.index');
    }

    public function getData(Request $request)
    {
        $query = Iuran::select('id_iuran', 'nama_iuran', 'besar_iuran', 'status')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        $result = $query->get();

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_iuran . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->editColumn('nama_iuran', function ($item) {
                return strtoupper($item->nama_iuran);
            })
            ->editColumn('besar_iuran', function ($item) {
                return Number::currency($item->besar_iuran, 'IDR', 'id');
            })
            ->editColumn('status', function ($item) {
                // Menampilkan status dalam bentuk badge dan kapital
                $badgeClass = ($item->status == 'aktif') ? 'light badge-primary' : 'light badge-danger';
                return '<span class="fs-7 badge ' . $badgeClass . '">' . strtoupper($item->status) . '</span>';
            })
            ->rawColumns(['aksi', 'status']) // Tambahkan status agar HTML bisa dirender
            ->make(true);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'besar_iuran' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        try {
            // Cek apakah nama_iuran sudah ada
            $existing = Iuran::where('nama_iuran', $request->nama_iuran)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Iuran ini sudah ada.',
                ], 409); // 409 Conflict
            }

            // Simpan data tahun akademik baru
            $iuran = new Iuran();
            $iuran->id_iuran = Str::uuid(); // Menggunakan UUID
            $iuran->nama_iuran = $request->nama_iuran;
            $iuran->besar_iuran = $request->besar_iuran;
            $iuran->status = $request->status;
            $iuran->save();

            return response()->json([
                'success' => true,
                'message' => 'Iuran berhasil ditambahkan.',
                'data' => $iuran,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan iuran: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan iuran.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Iuran::find($id);

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
            'nama_iuran' => 'required|string|max:255',
            'besar_iuran' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        try {
            // Cari data iuran berdasarkan ID
            $iuran = Iuran::find($id);

            if (!$iuran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Iuran tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            // Cek apakah nama_iuran sudah ada untuk entry lain
            $existing = Iuran::where('nama_iuran', $request->nama_iuran)
                ->where('id_iuran', '!=', $id) // Pastikan tidak mengecek entry yang sedang diupdate
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Iuran ini sudah ada.',
                ], 409); // 409 Conflict
            }

            // Update data iuran
            $iuran->nama_iuran = $request->nama_iuran;
            $iuran->besar_iuran = $request->besar_iuran;
            $iuran->status = $request->status;
            $iuran->save();

            return response()->json([
                'success' => true,
                'message' => 'Iuran berhasil diperbarui.',
                'data' => $iuran,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui iuran: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui iuran.',
            ], 500);
        }
    }
}
