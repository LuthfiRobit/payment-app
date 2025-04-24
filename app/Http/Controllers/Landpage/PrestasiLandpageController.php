<?php

namespace App\Http\Controllers\Landpage;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrestasiLandpageController extends Controller
{
    public function index()
    {
        return view('landpage.prestasi.views.index');
    }

    /**
     * Mengembalikan list semua prestasi dalam bentuk JSON.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function showList(): JsonResponse
    {
        $data = DB::table('prestasi')
            ->select('id_prestasi', 'tanggal', 'nama_prestasi', 'foto_prestasi')
            ->where('status', 'aktif')
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get()->map(function ($item) {
                $item->foto_prestasi = asset('uploads/prestasi/' . $item->foto_prestasi);  // Fixed the concatenation
                return $item;
            });

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $data,
        ], 200);
    }

    /**
     * Menampilkan detail prestasi berdasarkan ID dalam format JSON.
     * 
     * @param string $id ID UUID dari prestasi
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $prestasi = Prestasi::select('id_prestasi', 'tanggal', 'nama_prestasi', 'keterangan', 'foto_prestasi')->find($id);

            if (!$prestasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            // Handle the 'foto_prestasi' field (make sure the path is correct)
            $prestasi->foto_prestasi = asset('uploads/prestasi/' . $prestasi->foto_prestasi);

            return response()->json([
                'success' => true,
                'message' => 'Detail berhasil ditemukan',
                'data' => $prestasi,
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

    /**
     * Mengembalikan data prestasi secara paginasi menggunakan Query Builder.
     * Struktur respons disesuaikan dengan bawaan Laravel pagination.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showListPaginated(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 4);
        $currentPage = (int) $request->input('page', 1);

        $query = DB::table('prestasi')
            ->select('id_prestasi', 'tanggal', 'nama_prestasi', 'foto_prestasi')
            ->where('status', 'aktif')
            ->orderByDesc('tanggal');

        $total = $query->count();
        $results = $query
            ->offset(($currentPage - 1) * $perPage)
            ->limit($perPage)
            ->get()->map(function ($item) {
                $item->foto_prestasi = asset('uploads/prestasi/' . $item->foto_prestasi);  // Fixed the concatenation
                return $item;
            });


        return response()->json([
            'current_page' => $currentPage,
            'data' => $results,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage),
            'from' => ($results->isEmpty()) ? null : (($currentPage - 1) * $perPage) + 1,
            'to' => ($results->isEmpty()) ? null : (($currentPage - 1) * $perPage) + $results->count(),
            'next_page_url' => ($currentPage * $perPage < $total)
                ? url()->current() . '?page=' . ($currentPage + 1) . '&per_page=' . $perPage
                : null,
            'prev_page_url' => ($currentPage > 1)
                ? url()->current() . '?page=' . ($currentPage - 1) . '&per_page=' . $perPage
                : null,
        ]);
    }
}
