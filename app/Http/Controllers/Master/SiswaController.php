<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class SiswaController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index()
    {
        return view('master.siswa.views.index');
    }

    public function getData(Request $request)
    {
        $query = Siswa::select('id_siswa', 'nis', 'nama_siswa', 'nomor_telepon', 'kelas', 'status')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        // Filter berdasarkan kelas jika ada
        if ($request->has('filter_kelas') && $request->filter_kelas != '') {
            $query->where('kelas', $request->filter_kelas);
        }

        $result = $query->get();

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_siswa . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->editColumn('nis', function ($item) {
                return strtoupper($item->nis);
            })
            ->editColumn('nama_siswa', function ($item) {
                return strtoupper($item->nama_siswa);
            })
            ->editColumn('kelas', function ($item) {
                return strtoupper($item->kelas);
            })
            ->editColumn('nomor_telepon', function ($item) {
                return $item->nomor_telepon ? strtoupper($item->nomor_telepon) : 'BELUM ADA DATA';
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
            'nis' => 'required|string|max:20', // Wajib
            'nama_siswa' => 'required|string|max:255', // Wajib
            'status' => 'required|in:aktif,tidak aktif', // Wajib
            'jenis_kelamin' => 'required|in:laki-laki,perempuan', // Wajib
            'tanggal_lahir' => 'nullable|date', // Nullable
            'tempat_lahir' => 'nullable|string|max:255', // Nullable
            'alamat' => 'nullable|string|max:500', // Nullable
            'nomor_telepon' => 'nullable|string|max:15', // Nullable
            'email' => 'nullable|email|max:255', // Nullable
            'kelas' => 'required|string|max:50', // Wajib
        ]);

        try {
            // Cek apakah NISN sudah ada
            $existing = Siswa::where('nis', $request->nis)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa dengan NISN ini sudah ada.',
                ], 409); // 409 Conflict
            }

            // Simpan data siswa baru
            $siswa = new Siswa();
            $siswa->id_siswa = Str::uuid(); // Menggunakan UUID
            $siswa->nis = $request->nis;
            $siswa->nama_siswa = $request->nama_siswa;
            $siswa->status = $request->status;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tanggal_lahir = $request->tanggal_lahir;
            $siswa->tempat_lahir = $request->tempat_lahir;
            $siswa->alamat = $request->alamat;
            $siswa->nomor_telepon = $request->nomor_telepon;
            $siswa->email = $request->email;
            $siswa->kelas = $request->kelas;
            $siswa->save();

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil ditambahkan.',
                'data' => $siswa,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan siswa: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan siswa.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Siswa::find($id);

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
            'nis' => 'required|string|max:20', // Wajib
            'nama_siswa' => 'required|string|max:255', // Wajib
            'status' => 'required|in:aktif,tidak aktif', // Wajib
            'jenis_kelamin' => 'required|in:laki-laki,perempuan', // Wajib
            'tanggal_lahir' => 'nullable|date', // Nullable
            'tempat_lahir' => 'nullable|string|max:255', // Nullable
            'alamat' => 'nullable|string|max:500', // Nullable
            'nomor_telepon' => 'nullable|string|max:15', // Nullable
            'email' => 'nullable|email|max:255', // Nullable
            'kelas' => 'required|string|max:50', // Wajib
        ]);

        try {
            // Cari data siswa berdasarkan ID
            $siswa = Siswa::find($id);

            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            // Cek apakah NISN sudah ada untuk entry lain
            $existing = Siswa::where('nis', $request->nis)
                ->where('id_siswa', '!=', $id) // Pastikan tidak mengecek entry yang sedang diupdate
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa dengan NISN ini sudah ada.',
                ], 409); // 409 Conflict
            }

            // Update data siswa
            $siswa->nis = $request->nis;
            $siswa->nama_siswa = $request->nama_siswa;
            $siswa->status = $request->status;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tanggal_lahir = $request->tanggal_lahir;
            $siswa->tempat_lahir = $request->tempat_lahir;
            $siswa->alamat = $request->alamat;
            $siswa->nomor_telepon = $request->nomor_telepon;
            $siswa->email = $request->email;
            $siswa->kelas = $request->kelas;
            $siswa->save();

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil diperbarui.',
                'data' => $siswa,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui siswa: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui siswa.',
            ], 500);
        }
    }

    public function getList(Request $request)
    {
        try {
            $query = Siswa::select('id_siswa', 'nis', 'nama_siswa', 'kelas')
                ->where('status', 'aktif');

            // Cek jika ada parameter pencarian
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nis', 'LIKE', "%{$search}%")
                        ->orWhere('nama_siswa', 'LIKE', "%{$search}%");
                });
            }

            $query = $query->orderBy('created_at', 'DESC')->get();
            // Jika data ditemukan
            return $this->responseService->successResponse('Data siswa berhasil ditemukan', $query);
        } catch (\Exception $e) {

            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil data siswa: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil data siswa', $e->getMessage());
        }
    }

    public function importExcel(Request $request)
    {
        // Validasi input file
        $validateFile = $this->validateData($request->all(), [
            'file' => 'required|mimes:xlsx,xls'
        ], [
            'required' => 'Input :attribute wajib diisi.',
            'mimes' => 'Input :attribute harus :values.'
        ]);

        if ($validateFile !== null) {
            return $validateFile; // Mengembalikan respons validasi file
        }

        try {
            $file = $request->file('file');
            $import = new SiswaImport();
            $import->import($file);

            // Ambil kesalahan dan data yang berhasil dari SiswaImport
            $failures = $import->failures();
            $successfulRows = $import->successfulRows();

            // Jika ada kegagalan
            if ($failures || $successfulRows) {
                return response()->json([
                    'success' => true,
                    'message' => 'Impor selesai dengan beberapa hasil.',
                    'failures' => $failures,
                    'successes' => $successfulRows
                ], 200);
            }

            return response()->json(['success' => true, 'message' => 'Impor berhasil tanpa kesalahan!'], 200);
        } catch (\Exception $e) {
            Log::error('Import Excel error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Impor gagal: ' . $e->getMessage()], 500);
        }
    }

    public function validateData(array $data, array $rules, array $messages = [])
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();

            $response = [
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => []
            ];

            foreach ($errors->keys() as $key) {
                $response['errors'][$key] = $errors->get($key);
            }

            return response()->json($response, 400);
        }

        return null;
    }
}
