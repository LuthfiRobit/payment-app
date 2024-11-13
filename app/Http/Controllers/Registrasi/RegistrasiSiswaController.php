<?php

namespace App\Http\Controllers\Registrasi;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\AyahSiswaBaru;
use App\Models\IbuSiswaBaru;
use App\Models\KeluargaSiswaBaru;
use App\Models\SiswaBaru;
use App\Models\WaliSiswaBaru;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegistrasiSiswaController extends Controller
{
    public function store(Request $request)
    {
        // Validasi semua input
        $this->validateSiswaData($request);
        $this->validateIbuData($request);
        $this->validateAyahData($request);
        $this->validateWaliData($request);
        $this->validateKeluargaData($request);

        DB::beginTransaction(); // Memulai transaksi database

        try {
            // Simpan data siswa baru
            $siswaBaru = $this->saveSiswaData($request);

            // Simpan data Ibu
            $ibuSiswaBaru = $this->saveIbuData($request, $siswaBaru->id_siswa_baru);

            // Simpan data Ayah
            $ayahSiswaBaru = $this->saveAyahData($request, $siswaBaru->id_siswa_baru);

            // Simpan data Wali
            $waliSiswaBaru = $this->saveWaliData($request, $siswaBaru->id_siswa_baru);

            // Simpan data Keluarga
            $keluargaSiswaBaru = $this->saveKeluargaData($request, $siswaBaru->id_siswa_baru);

            // Commit transaksi jika semuanya berhasil
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa dan keluarga berhasil ditambahkan.',
                'data' => $siswaBaru,
            ], 201);
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();

            Log::error('Error saat menambahkan data siswa: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan data siswa.',
            ], 500);
        }
    }

    private function validateSiswaData($request)
    {
        $request->validate([
            'nik' => 'required|string|max:16|unique:siswa_baru,nik',
            'nama_lengkap_siswa' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'usia_saat_mendaftar' => 'required|integer',
            'jumlah_saudara' => 'required|integer',
            'anak_ke' => 'required|integer',
            'nomor_peci' => 'required|integer',
            'nomor_hp_wa' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'jarak_dari_rumah_ke_sekolah' => 'required|integer',
            'perjalanan_ke_sekolah' => 'required|in:jalan_kaki,sepeda,motor,mobil,angkot,ojek,lainnya',
            'sekolah_sebelum_mi' => 'required|string|max:255',
            'nama_ra_tk' => 'required|string|max:255',
            'alamat_ra_tk' => 'required|string|max:255',
            'imunisasi' => 'required|array',
            'imunisasi.*' => 'string', // Validasi untuk array imunisasi
            'foto_siswa' => 'nullable|mimes:jpeg,png,jpg|max:2048', // Validasi foto siswa (optional)
        ]);
    }

    private function validateIbuData($request)
    {
        $request->validate([
            'nama_ibu_kandung' => 'required|string|max:255',
            'status_ibu_kandung' => 'required|string|max:255',
            'nik_ibu' => 'required|string|max:16|unique:ibu_siswa_baru,nik_ibu',
            'tempat_lahir_ibu' => 'required|string|max:255',
            'tanggal_lahir_ibu' => 'required|date',
            'pendidikan_terakhir_ibu' => 'required|in:sd,smp,sma,diploma,sarjana,pascaSarjana',
            'pekerjaan_ibu' => 'required|in:ibuRumahTangga,guru,pegawaiNegeri,swasta,wiraswasta,lainnya',
            'penghasilan_per_bulan_ibu' => 'required|numeric|min:0',
            'alamat_ibu' => 'nullable|string|max:255',
            'scan_ktp_ibu' => 'nullable|mimes:jpeg,png,jpg|max:2048', // Validasi file KTP Ibu
        ]);
    }

    private function validateAyahData($request)
    {
        $request->validate([
            'nama_ayah_kandung' => 'required|string|max:255',
            'status_ayah_kandung' => 'required|string|max:255',
            'nik_ayah' => 'required|string|max:16|unique:ayah_siswa_baru,nik_ayah',
            'tempat_lahir_ayah' => 'required|string|max:255',
            'tanggal_lahir_ayah' => 'required|date',
            'pendidikan_terakhir_ayah' => 'required|in:sd,smp,sma,diploma,sarjana,pascaSarjana',
            'pekerjaan_ayah' => 'required|in:pegawaiNegeri,swasta,wiraswasta,buruh,lainnya',
            'penghasilan_per_bulan_ayah' => 'required|numeric|min:0',
            'alamat_ayah' => 'nullable|string|max:255',
            'scan_ktp_ayah' => 'nullable|mimes:jpeg,png,jpg|max:2048', // Validasi file KTP Ayah
        ]);
    }

    private function validateWaliData($request)
    {
        $request->validate([
            'nama_wali' => 'nullable|string|max:255',
            'scan_kk_wali' => 'nullable|mimes:jpeg,png,jpg|max:2048', // Validasi file KK Wali
            'scan_kartu_pkh' => 'nullable|mimes:jpeg,png,jpg|max:2048', // Validasi file Kartu PKH
            'scan_kartu_kks' => 'nullable|mimes:jpeg,png,jpg|max:2048', // Validasi file Kartu KKS
        ]);
    }

    private function validateKeluargaData($request)
    {
        $request->validate([
            'nama_kepala_keluarga' => 'required|string|max:255',
            'nomor_kk' => 'required|string|max:16',
            'alamat_rumah' => 'required|string|max:255',
            'yang_membiayai_sekolah' => 'required|in:ayah,ibu,wali',
        ]);
    }

    private function saveSiswaData($request)
    {
        $siswaBaru = new SiswaBaru();
        $siswaBaru->id_siswa_baru = Str::uuid();

        // Get the active academic year
        $activeAcademicYear = AppHelper::getActiveAcademicYear();

        // Ambil id_tahun_akademik dari tahun akademik aktif
        $tahunAkademikId = $activeAcademicYear->id_tahun_akademik;

        // Generate nomor registrasi (no_registrasi)
        $siswaBaru->no_registrasi = $this->generateNoRegistrasi($tahunAkademikId);

        // Memastikan 'imunisasi' adalah array dan mengonversinya ke JSON
        $imunisasi = $request->input('imunisasi');
        if (is_array($imunisasi)) {
            $siswaBaru->imunisasi = json_encode($imunisasi);  // Menyimpan sebagai JSON
        }

        $siswaBaru->fill($request->only([
            'nik',
            'nama_lengkap_siswa',
            'nama_panggilan',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'usia_saat_mendaftar',
            'jumlah_saudara',
            'anak_ke',
            'nomor_peci',
            'nomor_hp_wa',
            'email',
            'jarak_dari_rumah_ke_sekolah',
            'perjalanan_ke_sekolah',
            'sekolah_sebelum_mi',
            'nama_ra_tk',
            'alamat_ra_tk',
        ]));

        // Menambahkan tahun akademik ke data siswa
        $siswaBaru->tahun_akademik_id = $tahunAkademikId;

        // Handle foto siswa
        if ($request->hasFile('foto_siswa')) {
            $siswaBaru->foto_siswa = $this->uploadFile($request->file('foto_siswa'), 'foto_siswa');
        }

        $siswaBaru->save();
        return $siswaBaru;
    }

    private function saveIbuData($request, $siswaId)
    {
        $ibuSiswaBaru = new IbuSiswaBaru();
        $ibuSiswaBaru->id_ibu_siswa_baru = Str::uuid();
        $ibuSiswaBaru->siswa_baru_id = $siswaId;
        $ibuSiswaBaru->fill($request->only([
            'nama_ibu_kandung',
            'status_ibu_kandung',
            'nik_ibu',
            'tempat_lahir_ibu',
            'tanggal_lahir_ibu',
            'pendidikan_terakhir_ibu',
            'pekerjaan_ibu',
            'penghasilan_per_bulan_ibu',
            'alamat_ibu'
        ]));

        // Handle foto KTP ibu
        if ($request->hasFile('scan_ktp_ibu')) {
            $ibuSiswaBaru->scan_ktp_ibu = $this->uploadFile($request->file('scan_ktp_ibu'), 'ktp_ibu');
        }

        $ibuSiswaBaru->save();
        return $ibuSiswaBaru;
    }

    private function saveAyahData($request, $siswaId)
    {
        $ayahSiswaBaru = new AyahSiswaBaru();
        $ayahSiswaBaru->id_ayah_siswa_baru = Str::uuid();
        $ayahSiswaBaru->siswa_baru_id = $siswaId;
        $ayahSiswaBaru->fill($request->only([
            'nama_ayah_kandung',
            'status_ayah_kandung',
            'nik_ayah',
            'tempat_lahir_ayah',
            'tanggal_lahir_ayah',
            'pendidikan_terakhir_ayah',
            'pekerjaan_ayah',
            'penghasilan_per_bulan_ayah',
            'alamat_ayah'
        ]));

        // Handle foto KTP ayah
        if ($request->hasFile('scan_ktp_ayah')) {
            $ayahSiswaBaru->scan_ktp_ayah = $this->uploadFile($request->file('scan_ktp_ayah'), 'ktp_ayah');
        }

        $ayahSiswaBaru->save();
        return $ayahSiswaBaru;
    }

    private function saveWaliData($request, $siswaId)
    {
        $waliSiswaBaru = new WaliSiswaBaru();
        $waliSiswaBaru->id_wali_siswa_baru = Str::uuid();
        $waliSiswaBaru->siswa_baru_id = $siswaId;
        $waliSiswaBaru->nama_wali = $request->nama_wali;

        // Handle file uploads
        $this->uploadFileIfExist($request, 'scan_kk_wali', $waliSiswaBaru, 'scan_kk_wali');
        $this->uploadFileIfExist($request, 'scan_kartu_pkh', $waliSiswaBaru, 'scan_kartu_pkh');
        $this->uploadFileIfExist($request, 'scan_kartu_kks', $waliSiswaBaru, 'scan_kartu_kks');

        $waliSiswaBaru->save();
        return $waliSiswaBaru;
    }

    private function saveKeluargaData($request, $siswaId)
    {
        $keluargaSiswaBaru = new KeluargaSiswaBaru();
        $keluargaSiswaBaru->id_keluarga_siswa_baru = Str::uuid();
        $keluargaSiswaBaru->siswa_baru_id = $siswaId;
        $keluargaSiswaBaru->fill($request->only([
            'nama_kepala_keluarga',
            'nomor_kk',
            'alamat_rumah',
            'yang_membiayai_sekolah'
        ]));

        $keluargaSiswaBaru->save();
        return $keluargaSiswaBaru;
    }

    private function uploadFile($file, $folder)
    {
        $fileName = $folder . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/' . $folder), $fileName);
        return $fileName;
    }

    private function uploadFileIfExist($request, $fileKey, $model, $attribute)
    {
        if ($request->hasFile($fileKey)) {
            $model->$attribute = $this->uploadFile($request->file($fileKey), $fileKey);
        }
    }

    private function generateNoRegistrasi($tahunAkademikId)
    {
        // Ambil siswa terakhir berdasarkan tahun akademik dan urutkan berdasarkan no_registrasi
        $lastSiswa = SiswaBaru::where('tahun_akademik_id', $tahunAkademikId)
            ->orderBy('no_registrasi', 'desc')
            ->first();

        // Tentukan urutan baru untuk no_registrasi
        $urutan = $lastSiswa ? (int) substr($lastSiswa->no_registrasi, -3) + 1 : 1;

        // Format no_registrasi: Tahun + 4 digit + urutan
        $noRegistrasi = sprintf('%d%04d', date('Y'), $urutan);

        return $noRegistrasi;
    }
}
