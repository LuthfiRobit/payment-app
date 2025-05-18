<?php

namespace App\Http\Controllers\Landpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ArtikelLandpageController extends Controller
{

    public function index()
    {
        return view('landpage.artikel.views.index');
    }

    /**
     * Mengembalikan list semua artikel dalam bentuk JSON (terbatas 5 data).
     */
    public function showList(): JsonResponse
    {
        $data = DB::table('artikel')
            ->leftJoin('users', 'artikel.user_id', '=', 'users.id_user')
            ->select(
                'artikel.id_artikel',
                'artikel.user_id',
                'users.name as username',
                'artikel.judul',
                'artikel.isi',
                'artikel.gambar',
                'artikel.created_at'
            )
            ->where('artikel.status', 'aktif')
            ->orderByDesc('artikel.created_at')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                $item->judul = Str::words($item->judul, 6, '...');
                $item->isi = Str::words(strip_tags($item->isi), 35, '...');
                $item->gambar = $item->gambar ? asset('uploads/artikel/' . $item->gambar) : 'https://placehold.co/300X200?text=' . Str::words($item->judul, 4, '...');  // Fixed the concatenation
                $formattedDate = Carbon::parse($item->created_at)->translatedFormat('d F Y');
                $item->info = "{$formattedDate} | Oleh {$item->username}";
                return $item;
            });

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $data,
        ], 200);
    }

    /**
     * Mengembalikan data artikel secara paginasi.
     */
    public function showListPaginated(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 4);
        $currentPage = (int) $request->input('page', 1);

        $query = DB::table('artikel')
            ->leftJoin('users', 'artikel.user_id', '=', 'users.id_user')
            ->select(
                'artikel.id_artikel',
                'artikel.user_id',
                'users.name as username',
                'artikel.judul',
                'artikel.isi',
                'artikel.gambar',
                'artikel.created_at'
            )
            ->where('artikel.status', 'aktif')
            ->orderByDesc('artikel.created_at');

        $total = $query->count();
        $results = $query
            ->offset(($currentPage - 1) * $perPage)
            ->limit($perPage)
            ->get()
            ->map(function ($item) {
                $item->judul = Str::words($item->judul, 6, '...');
                $item->isi = Str::words(strip_tags($item->isi), 35, '...');
                $item->gambar = $item->gambar ? asset('uploads/artikel/' . $item->gambar) : 'https://placehold.co/300X200?text=' . Str::words($item->judul, 4, '...');  // Fixed the concatenation
                $formattedDate = Carbon::parse($item->created_at)->translatedFormat('d F Y');
                $item->info = "{$formattedDate} | Oleh {$item->username}";
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

    /**
     * Menampilkan detail artikel berdasarkan ID dalam format JSON.
     */
    public function show($id): JsonResponse
    {
        try {
            $artikel = Artikel::leftJoin('users', 'artikel.user_id', '=', 'users.id_user')
                ->select(
                    'artikel.id_artikel',
                    'artikel.user_id',
                    'users.name as username',
                    'artikel.judul',
                    'artikel.isi',
                    'artikel.gambar',
                    'artikel.dilihat',
                    'artikel.created_at'
                )
                ->find($id);

            if (!$artikel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            // Handle the 'gambar' field (make sure the path is correct)
            $artikel->gambar = $artikel->gambar ? asset('uploads/artikel/' . $artikel->gambar) : 'https://placehold.co/300X200?text=' . Str::words($artikel->judul, 4, '...');

            Carbon::setLocale('id');
            // Gunakan formatted date langsung dari objek datetime
            $artikel->created_at_formatted = Carbon::parse($artikel->created_at)->translatedFormat('d F Y');
            // Tambahkan info
            $artikel->info = "{$artikel->created_at_formatted} | Oleh {$artikel->username}";

            return response()->json([
                'success' => true,
                'message' => 'Detail berhasil ditemukan',
                'data' => $artikel,
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

    /**
     * Menampilkan detail artikel berdasarkan ID dalam bentuk view.
     */
    public function detail($id)
    {
        $artikel = Artikel::find($id);

        if (!$artikel) {
            abort(404, 'Artikel tidak ditemukan');
        }
        // Tambah 1 view
        $artikel->increment('dilihat');
        return view('landpage.artikel.views.detail');
    }
}
