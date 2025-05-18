<?php

namespace App\Http\Controllers\Landpage;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GaleriLandpageController extends Controller
{
    public function index()
    {
        return view('landpage.galeri.views.index');
    }

    /**
     * Mengembalikan list semua galeri dalam bentuk JSON.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function showList(): JsonResponse
    {
        $data = DB::table('galeri')
            ->select('id_galeri', 'tanggal', 'kegiatan', 'foto')
            ->where('status', 'aktif')
            ->orderByDesc('tanggal')
            ->limit(6)
            ->get()->map(function ($item) {
                $item->foto = $item->foto
                    ? asset('uploads/galeri/' . $item->foto)
                    : 'https://placehold.co/250x200?text=' . $item->kegiatan;
                return $item;
            });


        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $data,
        ], 200);
    }

    /**
     * Menampilkan detail galeri berdasarkan ID dalam format JSON.
     * 
     * @param string $id ID UUID dari galeri
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $galeri = Galeri::select('id_galeri', 'tanggal', 'kegiatan', 'keterangan', 'foto')->find($id);

            if (!$galeri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            // Handle the 'foto' field (make sure the path is correct)

            $galeri->foto = $galeri->foto
                ? asset('uploads/galeri/' . $galeri->foto)
                : 'https://placehold.co/250x200?text=' . $galeri->kegiatan;

            return response()->json([
                'success' => true,
                'message' => 'Detail berhasil ditemukan',
                'data' => $galeri,
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

    /**
     * Mengembalikan data galeri secara paginasi menggunakan Query Builder.
     * Struktur respons disesuaikan dengan bawaan Laravel pagination.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showListPaginated(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 8);
        $currentPage = (int) $request->input('page', 1);

        $query = DB::table('galeri')
            ->select('id_galeri', 'tanggal', 'kegiatan', 'foto')
            ->where('status', 'aktif')
            ->orderByDesc('tanggal');

        $total = $query->count();
        $results = $query
            ->offset(($currentPage - 1) * $perPage)
            ->limit($perPage)
            ->get()->map(function ($item) {
                $item->foto = $item->foto
                    ? asset('uploads/galeri/' . $item->foto)
                    : 'https://placehold.co/250x200?text=' . $item->kegiatan;
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
