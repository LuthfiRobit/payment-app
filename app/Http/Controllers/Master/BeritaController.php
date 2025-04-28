<?php

namespace App\Http\Controllers\Master;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BeritaController extends Controller
{
    public function index()
    {
        return view('master.berita.views.index');
    }

    public function getData(Request $request)
    {
        $query = Berita::select('id_berita', 'judul', 'status', 'dilihat', 'created_at')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        $result = $query->get();

        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_berita . '">
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

            if (Berita::where('slug', $slug)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah digunakan.',
                ], 409);
            }

            $fileName = null;
            if ($request->hasFile('gambar')) {
                $fileName = UploadHelper::uploadFile($request->file('gambar'), 'uploads/berita', 'berita');
            }

            $berita = new Berita();
            $berita->id_berita = Str::uuid();
            $berita->user_id = auth()->id(); // Optional: ganti sesuai kebutuhan
            $berita->judul = $request->judul;
            $berita->slug = $slug;
            $berita->isi = $request->isi;
            $berita->gambar = $fileName;
            $berita->status = $request->status;
            $berita->dilihat = 0;
            $berita->save();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan.',
                'data' => $berita,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan berita: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan berita.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Berita::find($id);

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
            Log::error('Error saat mengambil data berita: ' . $e->getMessage());

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
            $berita = Berita::find($id);

            if (!$berita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukan.',
                ], 404);
            }

            $slug = Str::slug($request->judul);
            $existing = Berita::where('slug', $slug)->where('id_berita', '!=', $id)->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah digunakan untuk berita lain.',
                ], 409);
            }

            $fileName = $berita->gambar;
            if ($request->hasFile('gambar')) {
                $fileName = UploadHelper::uploadFile($request->file('gambar'), 'uploads/berita', 'berita', $berita->gambar);
            }

            $berita->judul = $request->judul;
            $berita->slug = $slug;
            $berita->isi = $request->isi;
            $berita->gambar = $fileName;
            $berita->status = $request->status;
            $berita->save();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil diperbarui.',
                'data' => $berita,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui berita: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui berita.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $berita = Berita::find($id);

            if (!$berita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukan.',
                ], 404);
            }

            // Hapus file gambar jika ada
            if ($berita->gambar) {
                $filePath = public_path('uploads/berita/' . $berita->gambar);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data berita dari database
            $berita->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus berita: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus berita.',
            ], 500);
        }
    }
}
