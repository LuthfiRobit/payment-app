<?php

namespace App\Http\Controllers\Registrasi;

use App\Http\Controllers\Controller;
use App\Models\SettingPendaftaran;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class RegistrasiSettingController extends Controller
{
    public function index()
    {
        // Mengambil data tahun akademik
        $tahunAkademik = TahunAkademik::select('id_tahun_akademik', 'tahun', 'semester')->get();
        return view('ppdb.setting.views.index', compact('tahunAkademik'));
    }

    public function getData(Request $request)
    {
        $query = SettingPendaftaran::select('id_setting', 'tanggal_mulai', 'tanggal_selesai', 'biaya_pendaftaran', 'setting_pendaftaran.status', 'tahun_akademik.tahun', 'tahun_akademik.semester')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'setting_pendaftaran.tahun_akademik_id')
            ->orderBy('setting_pendaftaran.created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('setting_pendaftaran.status', $request->filter_status);
        }

        $result = $query->get();

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($result)
            ->addColumn('aksi', function ($item) {
                return '<button class="btn btn-outline-primary btn-sm edit-button" title="Edit" data-id="' . $item->id_setting . '">
                    <i class="fas fa-edit"></i>
                </button>';
            })
            ->editColumn('tahun', function ($item) {
                return strtoupper($item->tahun . ' - ' . $item->semester);
            })
            ->editColumn('tanggal_mulai', function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y'); // Menampilkan tgl mulai
            })
            ->editColumn('tanggal_selesai', function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y'); // Menampilkan tgl selesai
            })
            ->editColumn('biaya_pendaftaran', function ($item) {
                return Number::currency($item->biaya_pendaftaran, 'IDR', 'id'); // 
            })
            ->editColumn('status', function ($item) {
                $checked = ($item->status == 'aktif') ? 'checked disabled' : '';
                $label = ($item->status == 'aktif') ? 'Aktif' : 'Tidak Aktif';

                return '<div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch_' . $item->id_setting . '" ' . $checked . ' data-id="' . $item->id_setting . '">
                        <label class="form-check-label" for="switch_' . $item->id_setting . '">' . $label . '</label>
                    </div>';
            })
            ->rawColumns(['aksi', 'status']) // Menggunakan raw columns agar HTML bisa dirender
            ->make(true);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id_tahun_akademik',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'biaya_pendaftaran' => 'required|numeric',
        ]);

        try {
            // Simpan data setting pendaftaran baru
            $settingPendaftaran = new SettingPendaftaran();
            $settingPendaftaran->id_setting = Str::uuid();
            $settingPendaftaran->tahun_akademik_id = $request->tahun_akademik_id;
            $settingPendaftaran->tanggal_mulai = $request->tanggal_mulai;
            $settingPendaftaran->tanggal_selesai = $request->tanggal_selesai;
            $settingPendaftaran->biaya_pendaftaran = $request->biaya_pendaftaran;
            $settingPendaftaran->status = 'tidak aktif';
            $settingPendaftaran->save();

            return response()->json([
                'success' => true,
                'message' => 'Setting Pendaftaran berhasil ditambahkan.',
                'data' => $settingPendaftaran,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan setting pendaftaran: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan setting pendaftaran.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = SettingPendaftaran::find($id);

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
            Log::error('Error saat mengambil data setting pendaftaran: ' . $e->getMessage());
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
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id_tahun_akademik',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'biaya_pendaftaran' => 'required|numeric',
        ]);

        try {
            // Cari data setting pendaftaran berdasarkan ID
            $settingPendaftaran = SettingPendaftaran::find($id);

            if (!$settingPendaftaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Setting Pendaftaran tidak ditemukan.',
                ], 404);
            }

            // Update data setting pendaftaran
            $settingPendaftaran->tahun_akademik_id = $request->tahun_akademik_id;
            $settingPendaftaran->tanggal_mulai = $request->tanggal_mulai;
            $settingPendaftaran->tanggal_selesai = $request->tanggal_selesai;
            $settingPendaftaran->biaya_pendaftaran = $request->biaya_pendaftaran;
            $settingPendaftaran->save();

            return response()->json([
                'success' => true,
                'message' => 'Setting Pendaftaran berhasil diperbarui.',
                'data' => $settingPendaftaran,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui setting pendaftaran: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui setting pendaftaran.',
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:setting_pendaftaran,id_setting',
        ]);

        try {
            // Nonaktifkan semua setting pendaftaran
            SettingPendaftaran::query()->update(['status' => 'tidak aktif']);

            // Aktifkan setting pendaftaran yang dipilih
            $settingPendaftaran = SettingPendaftaran::find($validatedData['id']);
            $settingPendaftaran->status = 'aktif';
            $settingPendaftaran->save();

            return response()->json([
                'success' => true,
                'message' => 'Setting Pendaftaran berhasil diaktifkan.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat mengubah status setting pendaftaran: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status setting pendaftaran.',
            ], 500);
        }
    }
}
