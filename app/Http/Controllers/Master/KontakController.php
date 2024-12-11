<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class KontakController extends Controller
{
    public function index()
    {
        return view('master.kontak.views.index');
    }

    public function getData(Request $request)
    {
        $query = Kontak::select('id_kontak', 'kontak_telepon', 'kontak_email', 'status')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        $result = $query->get();

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_kontak . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->editColumn('telepon', function ($item) {
                return $item->kontak_telepon; // Menampilkan nomor telepon
            })
            ->editColumn('email', function ($item) {
                return $item->kontak_email; // Menampilkan email
            })
            ->editColumn('status', function ($item) {
                $checked = ($item->status == 'aktif') ? 'checked disabled' : '';
                $label = ($item->status == 'aktif') ? 'Aktif' : 'Tidak Aktif';

                return '<div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch_' . $item->id_kontak . '" ' . $checked . ' data-id="' . $item->id_kontak . '">
                        <label class="form-check-label" for="switch_' . $item->id_kontak . '">' . $label . '</label>
                    </div>';
            })
            ->rawColumns(['aksi', 'status']) // Menggunakan raw columns agar HTML bisa dirender
            ->make(true);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kontak_telepon' => 'required|string|max:50',
            'kontak_email' => 'required|email|max:100',
            'kontak_alamat' => 'required|string',
        ]);

        try {
            // Simpan data kontak baru
            $kontak = new Kontak();
            $kontak->id_kontak = Str::uuid();
            $kontak->kontak_telepon = $request->kontak_telepon;
            $kontak->kontak_email = $request->kontak_email;
            $kontak->kontak_alamat = $request->kontak_alamat;
            $kontak->status = 'tidak aktif';
            $kontak->save();

            return response()->json([
                'success' => true,
                'message' => 'Kontak berhasil ditambahkan.',
                'data' => $kontak,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan kontak: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan kontak.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Kontak::find($id);

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
            Log::error('Error saat mengambil data kontak: ' . $e->getMessage());
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
            'kontak_telepon' => 'required|string|max:50',
            'kontak_email' => 'required|email|max:100',
            'kontak_alamat' => 'required|string',
        ]);

        try {
            // Cari data kontak berdasarkan ID
            $kontak = Kontak::find($id);

            if (!$kontak) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kontak tidak ditemukan.',
                ], 404);
            }

            // Update data kontak
            $kontak->kontak_telepon = $request->kontak_telepon;
            $kontak->kontak_email = $request->kontak_email;
            $kontak->kontak_alamat = $request->kontak_alamat;
            $kontak->save();

            return response()->json([
                'success' => true,
                'message' => 'Kontak berhasil diperbarui.',
                'data' => $kontak,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui kontak: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kontak.',
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:kontak,id_kontak',
        ]);

        try {
            // Nonaktifkan semua kontak
            Kontak::query()->update(['status' => 'tidak aktif']);

            // Aktifkan kontak yang dipilih
            $kontak = Kontak::find($validatedData['id']);
            $kontak->status = 'aktif';
            $kontak->save();

            return response()->json([
                'success' => true,
                'message' => 'Kontak berhasil diaktifkan.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat mengubah status kontak: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status kontak.',
            ], 500);
        }
    }
}
