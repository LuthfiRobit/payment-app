<?php

namespace App\Http\Controllers\Master;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PrestasiController extends Controller
{
    public function index()
    {
        return view('master.prestasi.views.index');
    }

    public function getData(Request $request)
    {
        $query = Prestasi::select('id_prestasi', 'nama_prestasi', 'status', 'tanggal', 'created_at')
            ->orderBy('created_at', 'DESC');

        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        $result = $query->get();

        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_prestasi . '">
                <i class="fas fa-edit"></i>
            </button>';
            })
            ->editColumn('nama_prestasi', function ($item) {
                return strtoupper($item->nama_prestasi);
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
            'nama_prestasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak aktif',
            'foto_prestasi' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {

            $fileName = null;
            if ($request->hasFile('foto_prestasi')) {
                $fileName = UploadHelper::uploadFile($request->file('foto_prestasi'), 'uploads/prestasi', 'prestasi');
            }

            $prestasi = new Prestasi();
            $prestasi->id_prestasi = Str::uuid();
            $prestasi->tanggal = $request->tanggal;
            $prestasi->nama_prestasi = $request->nama_prestasi;
            $prestasi->keterangan = $request->keterangan;
            $prestasi->foto_prestasi = $fileName;
            $prestasi->status = $request->status;
            $prestasi->save();

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil ditambahkan.',
                'data' => $prestasi,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan prestasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan prestasi.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Prestasi::find($id);

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
            Log::error('Error saat mengambil data prestasi: ' . $e->getMessage());

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
            'nama_prestasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak aktif',
            'foto_prestasi' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $prestasi = Prestasi::find($id);

            if (!$prestasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prestasi tidak ditemukan.',
                ], 404);
            }

            $fileName = $prestasi->foto_prestasi;
            if ($request->hasFile('foto_prestasi')) {
                $fileName = UploadHelper::uploadFile($request->file('foto_prestasi'), 'uploads/prestasi', 'prestasi');
            }

            $prestasi->tanggal = $request->tanggal;
            $prestasi->nama_prestasi = $request->nama_prestasi;
            $prestasi->keterangan = $request->keterangan;
            $prestasi->status = $request->status;
            $prestasi->foto_prestasi = $fileName;
            $prestasi->save();

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil diperbarui.',
                'data' => $prestasi,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui prestasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui prestasi.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $prestasi = Prestasi::find($id);

            if (!$prestasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prestasi tidak ditemukan.',
                ], 404);
            }

            if ($prestasi->foto_prestasi) {
                $filePath = public_path('uploads/prestasi/' . $prestasi->foto_prestasi);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $prestasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus prestasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus prestasi.',
            ], 500);
        }
    }
}
