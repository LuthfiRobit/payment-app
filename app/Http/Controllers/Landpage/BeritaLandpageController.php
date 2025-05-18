<?php

namespace App\Http\Controllers\Landpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BeritaLandpageController extends Controller
{
    public function index()
    {
        return view('landpage.berita.views.index');
    }

    /**
     * Mengembalikan list semua berita dalam bentuk JSON (terbatas 5 data).
     */
    public function showList(): JsonResponse
    {
        $data = DB::table('berita')
            ->leftJoin('users', 'berita.user_id', '=', 'users.id_user')
            ->select(
                'berita.id_berita',
                'berita.user_id',
                'users.name as username',
                'berita.judul',
                'berita.isi',
                'berita.gambar',
                'berita.created_at'
            )
            ->where('berita.status', 'aktif')
            ->orderByDesc('berita.created_at')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                $item->judul = Str::words($item->judul, 6, '...');
                $item->isi = Str::words(strip_tags($item->isi), 35, '...');
                $item->gambar = $item->gambar ? asset('uploads/berita/' . $item->gambar) : 'https://placehold.co/300X200?text=' . Str::words($item->judul, 4, '...');  // Fixed the concatenation
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
     * Mengembalikan data berita secara paginasi.
     */
    public function showListPaginated(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 4);
        $currentPage = (int) $request->input('page', 1);

        $query = DB::table('berita')
            ->leftJoin('users', 'berita.user_id', '=', 'users.id_user')
            ->select(
                'berita.id_berita',
                'berita.user_id',
                'users.name as username',
                'berita.judul',
                'berita.isi',
                'berita.gambar',
                'berita.created_at'
            )
            ->where('berita.status', 'aktif')
            ->orderByDesc('berita.created_at');

        $total = $query->count();
        $results = $query
            ->offset(($currentPage - 1) * $perPage)
            ->limit($perPage)
            ->get()
            ->map(function ($item) {
                $item->judul = Str::words($item->judul, 6, '...');
                $item->isi = Str::words(strip_tags($item->isi), 35, '...');
                $item->gambar = $item->gambar ? asset('uploads/berita/' . $item->gambar) : 'https://placehold.co/300X200?text=' . Str::words($item->judul, 4, '...'); // Fixed the concatenation
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
     * Menampilkan detail berita berdasarkan ID dalam format JSON.
     */
    public function show($id): JsonResponse
    {
        try {
            $berita = Berita::leftJoin('users', 'berita.user_id', '=', 'users.id_user')
                ->select(
                    'berita.id_berita',
                    'berita.user_id',
                    'users.name as username',
                    'berita.judul',
                    'berita.isi',
                    'berita.gambar',
                    'berita.dilihat',
                    'berita.created_at'
                )
                ->find($id);

            if (!$berita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            // Handle the 'gambar' field (make sure the path is correct)
            $berita->gambar = $berita->gambar ? asset('uploads/berita/' . $berita->gambar) : 'https://placehold.co/300X200?text=' . Str::words($berita->judul, 4, '...');

            Carbon::setLocale('id');
            // Gunakan formatted date langsung dari objek datetime
            $berita->created_at_formatted = Carbon::parse($berita->created_at)->translatedFormat('d F Y');
            // Tambahkan info
            $berita->info = "{$berita->created_at_formatted} | Oleh {$berita->username}";
            return response()->json([
                'success' => true,
                'message' => 'Detail berhasil ditemukan',
                'data' => $berita,
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

    /**
     * Menampilkan detail berita berdasarkan ID dalam bentuk view.
     */
    public function detail($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            abort(404, 'Berita tidak ditemukan');
        }
        // Tambah 1 view
        $berita->increment('dilihat');
        return view('landpage.berita.views.detail');
    }
}
