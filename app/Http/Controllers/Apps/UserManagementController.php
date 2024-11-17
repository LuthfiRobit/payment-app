<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    protected $responseService;

    // Konstruktor untuk menginisialisasi ResponseService
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index()
    {
        return view('application.user.views.index');
    }

    public function getData(Request $request)
    {
        // Ambil data dari tabel users dengan kolom yang relevan
        $query = User::select('id_user', 'name', 'email', 'status', 'role')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        // Mengambil data dengan Yajra DataTables
        $result = $query->get();

        // Menggunakan DataTables untuk menampilkan data
        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_user . '">
                <i class="fas fa-edit"></i>
            </button>';
            })
            ->editColumn('status', function ($item) {
                $checked = ($item->status == 'aktif') ? 'checked' : '';
                $label = ($item->status == 'aktif') ? 'Aktif' : 'Tidak Aktif';

                return '<div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch_' . $item->id_user . '" ' . $checked . ' data-id="' . $item->id_user . '">
                        <label class="form-check-label" for="switch_' . $item->id_user . '">' . $label . '</label>
                    </div>';
            })
            ->editColumn('role', function ($item) {
                return ucfirst($item->role); // Mengubah role menjadi kapital pertama
            })
            ->rawColumns(['aksi', 'status']) // Tambahkan status agar HTML bisa dirender
            ->make(true);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email', // Pastikan email unik
            'role' => 'required|in:admin,kepsek', // Sesuaikan dengan role yang ada
            'password' => 'required|min:6|confirmed', // Password harus ada dan minimal 8 karakter
        ]);

        // Cek jika password dan konfirmasi password tidak cocok
        if ($request->password !== $request->password_confirmation) {
            return response()->json([
                'success' => false,
                'message' => 'Password dan konfirmasi password tidak cocok.',
                'errors' => [
                    'password' => ['Password dan konfirmasi password tidak cocok.']
                ]
            ], 422); // 422 Unprocessable Entity
        }

        try {
            // Membuat pengguna baru
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'],
                'password' => Hash::make($validatedData['password']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengguna baru berhasil dibuat.',
                'data' => $user,
            ], 201); // 201 Created
        } catch (\Exception $e) {
            Log::error('Error saat membuat pengguna: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat pengguna.',
            ], 500); // 500 Internal Server Error
        }
    }


    public function show($id)
    {
        try {
            // Cari data pengguna berdasarkan ID
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil ditemukan.',
                'data' => $user
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data pengguna: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pengguna.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',id_user', // Pastikan email unik kecuali milik pengguna yang sama
            'role' => 'required|in:admin,kepsek', // Sesuaikan dengan role yang ada
            'password' => 'nullable|min:6|confirmed', // Password hanya dibutuhkan jika diubah
        ]);

        // Cek jika password dan konfirmasi password tidak cocok
        if ($request->filled('password') && $request->password !== $request->password_confirmation) {
            return response()->json([
                'success' => false,
                'message' => 'Password dan konfirmasi password tidak cocok.',
                'errors' => [
                    'password' => ['Password dan konfirmasi password tidak cocok.']
                ]
            ], 422); // 422 Unprocessable Entity
        }

        try {
            // Cari pengguna berdasarkan ID
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            // Update nama, email, dan role
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->role = $validatedData['role'];

            // Jika password diubah, hash dan simpan
            if ($request->filled('password')) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil diperbarui.',
                'data' => $user,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui pengguna: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data pengguna.',
            ], 500); // 500 Internal Server Error
        }
    }


    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:users,id_user', // Pastikan ID pengguna ada di tabel users
            'status' => 'required|in:aktif,tidak aktif', // Validasi status
        ]);

        try {
            // Cari pengguna berdasarkan ID
            $user = User::find($validatedData['id']);

            // Cek jika status yang dipilih berbeda dengan status saat ini
            if ($user->status === $validatedData['status']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status pengguna sudah sesuai.',
                ], 400); // 400 Bad Request
            }

            // Ubah status pengguna
            $user->status = $validatedData['status'];
            $user->save();

            $message = $validatedData['status'] === 'aktif' ? 'Pengguna berhasil diaktifkan.' : 'Pengguna berhasil dinonaktifkan.';

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat mengubah status pengguna: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status pengguna.',
            ], 500); // 500 Internal Server Error
        }
    }
}
