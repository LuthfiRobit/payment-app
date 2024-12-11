<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Tentang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TentangController extends Controller
{
    public function index()
    {
        return view('master.tentang.views.index');
    }

    public function getData(Request $request)
    {
        // Mengambil data dari model Tentang dan mengurutkan berdasarkan waktu pembuatan
        $query = Tentang::select('id_tentang', 'deskripsi', 'img', 'status')
            ->orderBy('created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        // Mengambil data dari query
        $result = $query->get();

        // Menggunakan Yajra DataTables
        return DataTables::of($result)
            // Menambahkan kolom aksi
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_tentang . '">
                <i class="fas fa-edit"></i>
            </button>';
            })
            // Memotong deskripsi menjadi 10 kalimat
            ->editColumn('deskripsi', function ($item) {
                // Menghapus tag HTML jika ada
                $cleanedText = strip_tags($item->deskripsi);

                // Memisahkan teks berdasarkan spasi untuk mendapatkan kata
                $words = explode(' ', $cleanedText);

                // Ambil hanya 10 kata pertama
                $limited = array_slice($words, 0, 10);

                // Gabungkan kata-kata dan tambahkan "..." jika lebih dari 10 kata
                return implode(' ', $limited) . (count($words) > 10 ? '...' : '');
            })
            // Menampilkan gambar dalam kolom img
            ->editColumn('img', function ($item) {
                if (!empty($item->img)) {
                    return '<img src="' . asset($item->img) . '" alt="Image" width="100" height="100">';
                }
                return '<span>No Image</span>';
            })
            // Menambahkan kolom status dengan checkbox
            ->editColumn('status', function ($item) {
                $checked = ($item->status == 'aktif') ? 'checked disabled' : '';
                $label = ($item->status == 'aktif') ? 'Aktif' : 'Tidak Aktif';

                return '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch_' . $item->id_tentang . '" ' . $checked . ' data-id="' . $item->id_tentang . '">
                    <label class="form-check-label" for="switch_' . $item->id_tentang . '">' . $label . '</label>
                </div>';
            })
            // Memberikan pengaturan agar kolom aksi dan status bisa dirender dengan HTML
            ->rawColumns(['aksi', 'status', 'img'])
            ->make(true);
    }


    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'deskripsi' => 'required|string|max:1000',
            'img' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi gambar
        ]);

        // Validasi jumlah kata dalam deskripsi (misalnya 150 kata)
        $wordLimit = 150; // Batasan jumlah kata
        $deskripsiWords = preg_split('/\s+/', strip_tags($request->deskripsi)); // Hitung kata setelah menghapus HTML tags
        if (count($deskripsiWords) > $wordLimit) {
            return response()->json([
                'success' => false,
                'message' => "Deskripsi tidak boleh lebih dari $wordLimit kata.",
            ], 400);
        }

        // Proses upload gambar
        $imgName = '';
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $imgName = 'img_' . now()->timestamp . '.' . $file->getClientOriginalExtension();
            $imgPath = public_path('uploads/foto_tentang/' . $imgName);
            $file->move(public_path('uploads/foto_tentang'), $imgName);
        }

        try {
            // Simpan data tentang baru
            $tentang = new Tentang();
            $tentang->id_tentang = Str::uuid();
            $tentang->deskripsi = $request->deskripsi;
            $tentang->img = 'uploads/foto_tentang/' . $imgName; // Path gambar yang disimpan
            $tentang->status = 'tidak aktif'; // Status default
            $tentang->save();

            return response()->json([
                'success' => true,
                'message' => 'Tentang berhasil ditambahkan.',
                'data' => $tentang,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan tentang: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan tentang.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Tentang::find($id);

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
            Log::error('Error saat mengambil data tentang: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Data deskripsi yang diterima: ' . $request->input('deskripsi')); // Log deskripsi
        // Validasi input
        $validatedData = $request->validate([
            'deskripsi' => 'required|string|max:1000', // Validasi deskripsi dengan batasan karakter
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi gambar jika ada
        ]);

        // Validasi jumlah kata dalam deskripsi (misalnya 150 kata)
        $wordLimit = 150; // Batasan jumlah kata
        $deskripsiWords = preg_split('/\s+/', strip_tags($request->deskripsi)); // Hitung kata setelah menghapus HTML tags
        if (count($deskripsiWords) > $wordLimit) {
            return response()->json([
                'success' => false,
                'message' => "Deskripsi tidak boleh lebih dari $wordLimit kata.",
            ], 400);
        }

        try {
            // Cari data tentang berdasarkan ID
            $tentang = Tentang::find($id);

            if (!$tentang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tentang tidak ditemukan.',
                ], 404);
            }

            // Update deskripsi
            $tentang->deskripsi = $request->deskripsi;

            // Cek apakah ada gambar baru
            if ($request->hasFile('img')) {
                // Hapus gambar lama jika ada (untuk menghindari penggunaan gambar yang tidak terpakai)
                if ($tentang->img && file_exists(public_path($tentang->img))) {
                    unlink(public_path($tentang->img)); // Menghapus file gambar lama
                }

                // Proses upload gambar baru
                $file = $request->file('img');
                $imgName = 'img_' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                $imgPath = public_path('uploads/foto_tentang/' . $imgName);
                $file->move(public_path('uploads/foto_tentang'), $imgName);

                // Update path gambar
                $tentang->img = 'uploads/foto_tentang/' . $imgName;
            }

            // Simpan perubahan data
            $tentang->save();

            return response()->json([
                'success' => true,
                'message' => 'Tentang berhasil diperbarui.',
                'data' => $tentang,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui tentang: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui tentang.',
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:tentang,id_tentang',
        ]);

        try {
            // Nonaktifkan semua tentang
            Tentang::query()->update(['status' => 'tidak aktif']);

            // Aktifkan tentang yang dipilih
            $tentang = Tentang::find($validatedData['id']);
            $tentang->status = 'aktif';
            $tentang->save();

            return response()->json([
                'success' => true,
                'message' => 'Tentang berhasil diaktifkan.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat mengubah status tentang: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status tentang.',
            ], 500);
        }
    }
}
