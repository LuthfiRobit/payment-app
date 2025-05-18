<?php

namespace App\Http\Controllers\Master;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ArtikelController extends Controller
{

    public function index()
    {
        return view('master.artikel.views.index');
    }

    public function getData(Request $request)
    {
        $query = Artikel::select('id_artikel', 'judul', 'status', 'dilihat', 'created_at')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        $result = $query->get();

        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_artikel . '">
                <i class="fas fa-edit"></i>
            </button>';
            })
            ->editColumn('judul', function ($item) {
                return strtoupper($item->judul);
            })
            ->editColumn('status', function ($item) {
                $badgeClass = ($item->status == 'aktif') ? 'light badge-primary' : 'light badge-danger';
                return '<span class="fs-7 badge ' . $badgeClass . '">' . strtoupper($item->status) . '</span>';
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'status' => 'required|in:aktif,tidak aktif',
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $slug = Str::slug($request->judul);

            if (Artikel::where('slug', $slug)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah digunakan.',
                ], 409);
            }

            $fileName = null;
            if ($request->hasFile('gambar')) {
                $fileName = UploadHelper::uploadFile($request->file('gambar'), 'uploads/artikel', 'artikel');
            }

            $artikel = new Artikel();
            $artikel->id_artikel = Str::uuid();
            $artikel->user_id = auth()->id(); // Optional: ganti sesuai kebutuhan
            $artikel->judul = $request->judul;
            $artikel->slug = $slug;
            $artikel->isi = $request->isi;
            $artikel->gambar = $fileName;
            $artikel->status = $request->status;
            $artikel->dilihat = 0;
            $artikel->save();

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil ditambahkan.',
                'data' => $artikel,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan artikel: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan artikel.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Artikel::find($id);

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
            Log::error('Error saat mengambil data artikel: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'status' => 'required|in:aktif,tidak aktif',
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $artikel = Artikel::find($id);

            if (!$artikel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan.',
                ], 404);
            }

            $slug = Str::slug($request->judul);
            $existing = Artikel::where('slug', $slug)->where('id_artikel', '!=', $id)->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah digunakan untuk artikel lain.',
                ], 409);
            }

            $fileName = $artikel->gambar;
            if ($request->hasFile('gambar')) {
                $fileName = UploadHelper::uploadFile($request->file('gambar'), 'uploads/artikel', 'artikel', $artikel->gambar);
            }

            $artikel->judul = $request->judul;
            $artikel->slug = $slug;
            $artikel->isi = $request->isi;
            $artikel->gambar = $fileName;
            $artikel->status = $request->status;
            $artikel->save();

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil diperbarui.',
                'data' => $artikel,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui artikel: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui artikel.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $artikel = Artikel::find($id);

            if (!$artikel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan.',
                ], 404);
            }

            // Hapus file gambar jika ada
            if ($artikel->gambar) {
                $filePath = public_path('uploads/artikel/' . $artikel->gambar);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data artikel dari database
            $artikel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus artikel: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus artikel.',
            ], 500);
        }
    }
}
