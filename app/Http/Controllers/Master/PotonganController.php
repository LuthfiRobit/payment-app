<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Potongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class PotonganController extends Controller
{
    public function index()
    {
        return view('master.potongan.views.index');
    }

    public function getData(Request $request)
    {
        $query = Potongan::select('id_potongan', 'nama_potongan', 'status')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        $result = $query->get();

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_potongan . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->editColumn('nama_potongan', function ($item) {
                return strtoupper($item->nama_potongan);
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
            'nama_potongan' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        try {
            // Cek apakah nama_potongan sudah ada
            $existing = Potongan::where('nama_potongan', $request->nama_potongan)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Potongan ini sudah ada.',
                ], 409); // 409 Conflict
            }

            // Simpan data tahun akademik baru
            $potongan = new Potongan();
            $potongan->id_potongan = Str::uuid(); // Menggunakan UUID
            $potongan->nama_potongan = $request->nama_potongan;
            $potongan->status = $request->status;
            $potongan->save();

            return response()->json([
                'success' => true,
                'message' => 'Potongan berhasil ditambahkan.',
                'data' => $potongan,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan potongan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan potongan.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Potongan::find($id);

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
            'nama_potongan' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        try {
            // Cari data potongan berdasarkan ID
            $potongan = Potongan::find($id);

            if (!$potongan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Potongan tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            // Cek apakah nama_potongan sudah ada untuk entry lain
            $existing = Potongan::where('nama_potongan', $request->nama_potongan)
                ->where('id_potongan', '!=', $id) // Pastikan tidak mengecek entry yang sedang diupdate
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Potongan ini sudah ada.',
                ], 409); // 409 Conflict
            }

            // Update data potongan
            $potongan->nama_potongan = $request->nama_potongan;
            $potongan->status = $request->status;
            $potongan->save();

            return response()->json([
                'success' => true,
                'message' => 'Potongan berhasil diperbarui.',
                'data' => $potongan,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui potongan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui potongan.',
            ], 500);
        }
    }
}
