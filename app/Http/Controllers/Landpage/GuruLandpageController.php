<?php

namespace App\Http\Controllers\Landpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruLandpageController extends Controller
{
    public function index()
    {
        return view('landpage.guru.views.index');
    }

    /**
     * Mengembalikan list semua guru dalam bentuk JSON.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function showList(Request $request): JsonResponse
    {
        $kategori = $request->input('kategori'); // nilai: 'guru' atau 'karyawan'

        // Validasi kategori (optional tapi aman)
        if (!in_array($kategori, ['guru', 'karyawan'])) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak valid. Pilih guru atau karyawan.',
                'data' => [],
            ], 400);
        }

        $data = DB::table('guru_karyawan')
            ->select('id_guru_karyawan', 'nama', 'jabatan', 'kategori', 'foto')
            ->where('status', 'aktif')
            ->where('kategori', $kategori)
            ->orderBy('urutan', 'ASC')
            ->get()
            ->map(function ($item) {
                $item->foto = $item->foto
                    ? asset('uploads/guru_karyawan/' . $item->foto)
                    : 'https://placehold.co/200x250?text=' . $item->nama;
                return $item;
            });

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $data,
        ], 200);
    }
}
