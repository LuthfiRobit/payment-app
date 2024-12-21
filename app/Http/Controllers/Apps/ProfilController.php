<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfilController extends Controller
{
    public function index()
    {
        return view('application.profil.views.index');
    }

    public function updateData(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $id . ',id_user', // Pastikan email unik kecuali milik pengguna yang sama
        ]);

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

            // Jika password diubah, hash dan simpan
            if ($request->filled('password')) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui.',
                'data' => $user,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui profil: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data profil.',
            ], 500); // 500 Internal Server Error
        }
    }

    public function updatePassword(Request $request, $id)
    {
        // Pesan validasi kustom
        $messages = [
            'current_password.required' => 'Password sebelumnya wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru harus terdiri dari minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung kombinasi huruf dan angka.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation.min' => 'Konfirmasi password harus terdiri dari minimal 6 karakter.',
        ];

        // Validasi input dengan pesan kustom
        $validatedData = $request->validate([
            'current_password' => 'required|string', // Validasi untuk password sebelumnya
            'password' => [
                'required',
                'string',
                'min:6', // Password baru harus minimal 6 karakter
                'confirmed', // Password dan konfirmasi harus cocok
                function ($attribute, $value, $fail) {
                    if (!preg_match('/[A-Za-z]/', $value) || !preg_match('/\d/', $value)) {
                        $fail('Password harus mengandung kombinasi huruf dan angka.');
                    }
                }
            ],
            'password_confirmation' => 'required|string|min:6',
        ], $messages); // Menambahkan pesan kustom

        try {
            // Cari pengguna berdasarkan ID
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            // Validasi password sebelumnya
            if (!Hash::check($validatedData['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password sebelumnya salah.',
                ], 400); // 400 Bad Request
            }

            // Jika password baru valid, hash dan simpan
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diperbarui.',
                'data' => $user,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui password: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui password.',
            ], 500); // 500 Internal Server Error
        }
    }
}
