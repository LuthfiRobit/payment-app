<?php

namespace App\Http\Controllers\Master;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\GuruKaryawan;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index()
    {
        return view('master.guru.views.index');
    }

    public function getData(Request $request)
    {
        $query = GuruKaryawan::select('id_guru_karyawan', 'nama', 'jabatan', 'kategori', 'urutan', 'status')
            ->orderBy('urutan', 'ASC');

        // Filter berdasarkan status
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        // Filter berdasarkan kategori
        if ($request->has('filter_kategori') && $request->filter_kategori != '') {
            $query->where('kategori', $request->filter_kategori);
        }

        $result = $query->get();

        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_guru_karyawan . '">
                        <i class="fas fa-edit"></i>
                    </button>';
            })
            ->editColumn('nama', function ($item) {
                return strtoupper($item->nama);
            })
            ->editColumn('jabatan', function ($item) {
                return strtoupper($item->jabatan);
            })
            ->editColumn('kategori', function ($item) {
                $badgeClass = $item->kategori === 'guru' ? 'light badge-success' : 'light badge-secondary';
                return '<span class="fs-7 badge ' . $badgeClass . '">' . strtoupper($item->kategori) . '</span>';
            })
            ->editColumn('status', function ($item) {
                $badgeClass = $item->status === 'aktif' ? 'light badge-primary' : 'light badge-danger';
                return '<span class="fs-7 badge ' . $badgeClass . '">' . strtoupper($item->status) . '</span>';
            })
            ->rawColumns(['aksi', 'kategori', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'required|in:guru,karyawan',
            'status' => 'required|in:aktif,tidak aktif',
            'urutan' => 'nullable|integer|min:1',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $guru = new GuruKaryawan();
            $guru->nama = $request->nama;
            $guru->jabatan = $request->jabatan;
            $guru->kategori = $request->kategori;
            $guru->status = $request->status;
            $guru->urutan = $request->urutan ?? 1;

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                $prefix = $request->kategori === 'guru' ? 'guru' : 'karyawan';
                $fileName = UploadHelper::uploadFile(
                    $request->file('foto'),
                    'uploads/guru_karyawan',
                    $prefix
                );
                $guru->foto = $fileName;
            }

            $guru->save();

            return response()->json([
                'success' => true,
                'message' => 'Data guru/karyawan berhasil ditambahkan.',
                'data' => $guru,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan guru/karyawan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = GuruKaryawan::find($id);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data guru/karyawan tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data guru/karyawan berhasil ditemukan',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data guru/karyawan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data guru/karyawan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'required|in:guru,karyawan',
            'status' => 'required|in:aktif,tidak aktif',
            'urutan' => 'nullable|integer|min:1',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $guru = GuruKaryawan::find($id);

            if (!$guru) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data guru/karyawan tidak ditemukan.',
                ], 404);
            }

            $fileName = $guru->foto;

            if ($request->hasFile('foto')) {
                $prefix = $request->kategori === 'guru' ? 'guru' : 'karyawan';
                $fileName = UploadHelper::uploadFile(
                    $request->file('foto'),
                    'uploads/guru_karyawan',
                    $prefix,
                    $guru->foto // lama
                );
            }

            $guru->nama = $request->nama;
            $guru->jabatan = $request->jabatan;
            $guru->kategori = $request->kategori;
            $guru->status = $request->status;
            $guru->urutan = $request->urutan ?? $guru->urutan;
            $guru->foto = $fileName;

            $guru->save();

            return response()->json([
                'success' => true,
                'message' => 'Data guru/karyawan berhasil diperbarui.',
                'data' => $guru,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui guru/karyawan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data.',
            ], 500);
        }
    }
}
