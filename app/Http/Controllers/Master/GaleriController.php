<?php

namespace App\Http\Controllers\Master;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class GaleriController extends Controller
{
    public function index()
    {
        return view('master.galeri.views.index');
    }

    public function getData(Request $request)
    {
        $query = Galeri::select('id_galeri', 'kegiatan', 'status', 'tanggal', 'created_at')
            ->orderBy('created_at', 'DESC');

        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        $result = $query->get();

        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_galeri . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->editColumn('kegiatan', function ($item) {
                return strtoupper($item->kegiatan);
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
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak aktif',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $fileName = null;
            if ($request->hasFile('foto')) {
                $fileName = UploadHelper::uploadFile($request->file('foto'), 'uploads/galeri', 'galeri');
            }

            $galeri = new Galeri();
            $galeri->id_galeri = Str::uuid();
            $galeri->tanggal = $request->tanggal;
            $galeri->kegiatan = $request->kegiatan;
            $galeri->keterangan = $request->keterangan;
            $galeri->foto = $fileName;
            $galeri->status = $request->status;
            $galeri->save();

            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil ditambahkan.',
                'data' => $galeri,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan galeri: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan galeri.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Galeri::find($id);

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
            Log::error('Error saat mengambil data galeri: ' . $e->getMessage());

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
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak aktif',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $galeri = Galeri::find($id);

            if (!$galeri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Galeri tidak ditemukan.',
                ], 404);
            }

            $fileName = $galeri->foto;
            if ($request->hasFile('foto')) {
                $fileName = UploadHelper::uploadFile($request->file('foto'), 'uploads/galeri', 'galeri', $galeri->foto);
            }

            $galeri->tanggal = $request->tanggal;
            $galeri->kegiatan = $request->kegiatan;
            $galeri->keterangan = $request->keterangan;
            $galeri->status = $request->status;
            $galeri->foto = $fileName;
            $galeri->save();

            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil diperbarui.',
                'data' => $galeri,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui galeri: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui galeri.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $galeri = Galeri::find($id);

            if (!$galeri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Galeri tidak ditemukan.',
                ], 404);
            }

            if ($galeri->foto) {
                $filePath = public_path('uploads/galeri/' . $galeri->foto);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $galeri->delete();

            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus galeri: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus galeri.',
            ], 500);
        }
    }
}
