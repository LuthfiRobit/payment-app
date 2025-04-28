<?php

namespace App\Http\Controllers\Registrasi;

use App\Exports\SiswaBaruExport;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\AyahSiswaBaru;
use App\Models\IbuSiswaBaru;
use App\Models\KeluargaSiswaBaru;
use App\Models\Siswa;
use App\Models\SiswaBaru;
use App\Models\TahunAkademik;
use App\Models\WaliSiswaBaru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RegistrasiController extends Controller
{
    public function index()
    {
        // Mengambil data tahun akademik
        $tahunAkademik = TahunAkademik::select('id_tahun_akademik', 'tahun', 'semester')->get();
        return view('ppdb.views.index', compact('tahunAkademik'));
    }

    public function getData(Request $request)
    {
        // Menyiapkan filter dari request
        $filters = [
            'filter_tahun' => $request->input('filter_tahun', ''),
            'filter_status' => $request->input('filter_status', ''),
        ];

        // Mengambil data siswa berdasarkan filter
        $query = SiswaBaru::getData($filters);

        // Membuat DataTables dengan query yang sudah difilter
        return DataTables::of($query)
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" class="siswa-checkbox form-check-input" value="' . $item->id_siswa_baru . '">';
            })
            ->addColumn('aksi', function ($item) {
                // Tombol aksi untuk setiap siswa
                return '<div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);" data-action="edit_siswa" data-id="' . $item->id_siswa_baru . '">
                                    <i class="fas fa-user-edit"></i> Edit Data Siswa
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" data-action="edit_ortu" data-id="' . $item->id_siswa_baru . '">
                                    <i class="fas fa-user-friends"></i> Edit Data Orang Tua
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" data-action="edit_keluarga" data-id="' . $item->id_siswa_baru . '">
                                    <i class="fas fa-users"></i> Edit Status Keluarga
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" data-action="edit_wali" data-id="' . $item->id_siswa_baru . '">
                                    <i class="fas fa-user-tie"></i> Edit Data Wali
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" data-action="edit_status" data-id="' . $item->id_siswa_baru . '" data-status="' . $item->status . '">
                                    <i class="fas fa-edit"></i> Edit Status Penerimaan
                                </a>
                            </div>
                        </div>';
            })
            ->addColumn('tahun_akademik', function ($item) {
                // Mengambil data tahun akademik, bisa Anda sesuaikan jika ada relasi dengan tabel lain
                return $item->tahun . ' - ' . $item->semester; // Misalnya, jika ingin menggabungkan nama tahun akademik, Anda bisa relasikan ke tabel lain
            })
            ->addColumn('no_registrasi', function ($item) {
                // Menampilkan no registrasi
                return $item->no_registrasi;
            })
            ->addColumn('nama_siswa', function ($item) {
                // Menampilkan nama siswa
                return $item->nama_lengkap_siswa;
            })
            ->addColumn('nik', function ($item) {
                // Menampilkan NIK siswa
                return $item->nik;
            })
            ->addColumn('sekolah_sebelum_mi', function ($item) {
                // Menampilkan sekolah sebelum MI
                return $item->sekolah_sebelum_mi;
            })
            ->addColumn('usia', function ($item) {
                // Menampilkan usia siswa saat mendaftar
                return $item->usia_saat_mendaftar;
            })
            ->editColumn('status', function ($item) {
                // Menampilkan status dalam bentuk badge dengan warna sesuai status
                $badgeClass = '';
                $statusLabel = '';

                switch ($item->status) {
                    case 'diterima':
                        $badgeClass = 'badge-success';
                        $statusLabel = 'DITERIMA';
                        break;
                    case 'ditolak':
                        $badgeClass = 'badge-danger';
                        $statusLabel = 'DITOLAK';
                        break;
                    case 'digenerate':
                        $badgeClass = 'badge-warning';
                        $statusLabel = 'DIGENERATE';
                        break;
                    default:
                        $badgeClass = 'badge-secondary';
                        $statusLabel = 'BELUM DIPROSES';
                        break;
                }

                return '<span class="badge ' . $badgeClass . '">' . $statusLabel . '</span>';
            })
            ->rawColumns(['checkbox', 'aksi', 'status']) // Menandai kolom yang dapat berisi HTML
            ->make(true); // Mengembalikan data dalam format JSON yang siap digunakan di frontend

    }

    public function create()
    {
        return view('ppdb.views.create');
    }

    public function showSiswa($id)
    {
        try {
            $data = SiswaBaru::find($id);

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
            Log::error('Error saat mengambil data siswa baru: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateSiswa(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string|max:16|unique:siswa_baru,nik,' . $id . ',id_siswa_baru', // Ignore unique check for the current record
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
            'imunisasi.*' => 'string', // Validation for array of immunization
            'foto_siswa' => $request->hasFile('foto_siswa')
                ? 'nullable|mimes:jpeg,jpg,png|max:2048'
                : 'nullable', // Validation for optional file upload
        ]);

        $siswa = SiswaBaru::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        DB::beginTransaction(); // Start DB transaction

        try {
            // Handle file upload if a new file is provided

            $file_name = $siswa->foto_siswa;
            if ($request->hasFile('foto_siswa')) {
                $file_name = UploadHelper::uploadFile($request->file('foto_siswa'), 'uploads/foto_siswa', 'foto_siswa', $siswa->foto_siswa);
            }

            // Update the student's data
            $siswa->update([
                'nik' => $request->nik,
                'nama_lengkap_siswa' => $request->nama_lengkap_siswa,
                'nama_panggilan' => $request->nama_panggilan,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia_saat_mendaftar' => $request->usia_saat_mendaftar,
                'jumlah_saudara' => $request->jumlah_saudara,
                'anak_ke' => $request->anak_ke,
                'nomor_peci' => $request->nomor_peci,
                'nomor_hp_wa' => $request->nomor_hp_wa,
                'email' => $request->email,
                'jarak_dari_rumah_ke_sekolah' => $request->jarak_dari_rumah_ke_sekolah,
                'perjalanan_ke_sekolah' => $request->perjalanan_ke_sekolah,
                'sekolah_sebelum_mi' => $request->sekolah_sebelum_mi,
                'nama_ra_tk' => $request->nama_ra_tk,
                'alamat_ra_tk' => $request->alamat_ra_tk,
                'foto_siswa' => $file_name,
                'imunisasi' => $request->imunisasi, // Ensure this is handled properly
            ]);

            DB::commit(); // Commit transaction

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diperbarui.',
                'data' => $siswa,
            ], 200); // 200 OK
        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback transaction on failure
            Log::error('Update siswa baru gagal: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data siswa baru.',
            ], 500); // 500 Internal Server Error
        }
    }

    public function showOrtu($id)
    {
        try {
            $data['ayah'] = AyahSiswaBaru::where('siswa_baru_id', $id)->first();
            $data['ibu'] = IbuSiswaBaru::where('siswa_baru_id', $id)->first();

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
            Log::error('Error saat mengambil data ortu siswa baru: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateOrtu(Request $request, $id)
    {
        $request->validate([
            'nama_ayah_kandung' => 'required|string|max:255',
            'status_ayah_kandung' => 'required|string|max:255',
            'nik_ayah' => 'required|string|max:16|unique:ayah_siswa_baru,nik_ayah,' . $id . ',siswa_baru_id',
            'tempat_lahir_ayah' => 'required|string|max:255',
            'tanggal_lahir_ayah' => 'required|date',
            'pendidikan_terakhir_ayah' => 'required|in:sd,smp,sma,diploma,sarjana,pascaSarjana',
            'pekerjaan_ayah' => 'required|in:pegawaiNegeri,swasta,wiraswasta,buruh,lainnya',
            'penghasilan_per_bulan_ayah' => 'required|numeric|min:0',
            'alamat_ayah' => 'nullable|string|max:255',
            'scan_ktp_ayah' => $request->hasFile('scan_ktp_ayah') ? 'nullable|mimes:jpeg,jpg,png|max:2048' : 'nullable',  // Validate file

            'nama_ibu_kandung' => 'required|string|max:255',
            'status_ibu_kandung' => 'required|string|max:255',
            'nik_ibu' => 'required|string|max:16|unique:ibu_siswa_baru,nik_ibu,' . $id . ',siswa_baru_id',
            'tempat_lahir_ibu' => 'required|string|max:255',
            'tanggal_lahir_ibu' => 'required|date',
            'pendidikan_terakhir_ibu' => 'required|in:sd,smp,sma,diploma,sarjana,pascaSarjana',
            'pekerjaan_ibu' => 'required|in:ibuRumahTangga,guru,pegawaiNegeri,swasta,wiraswasta,lainnya',
            'penghasilan_per_bulan_ibu' => 'required|numeric|min:0',
            'alamat_ibu' => 'nullable|string|max:255',
            'scan_ktp_ibu' => $request->hasFile('scan_ktp_ibu') ? 'nullable|mimes:jpeg,jpg,png|max:2048' : 'nullable',  // Validate file
        ]);

        // Fetch Ayah and Ibu data from the database based on siswa_baru_id
        $ayah = AyahSiswaBaru::where('siswa_baru_id', $id)->first();
        $ibu = IbuSiswaBaru::where('siswa_baru_id', $id)->first();

        if (!$ayah || !$ibu) {
            return response()->json([
                'success' => false,
                'message' => 'Data orang tua tidak ditemukan',
            ], 404);
        }

        DB::beginTransaction(); // Start DB transaction

        try {
            // Upload file baru jika tersedia
            if ($request->hasFile('scan_ktp_ayah')) {
                $ayah->scan_ktp_ayah = UploadHelper::uploadFile(
                    $request->file('scan_ktp_ayah'),
                    'uploads/ktp_ayah',
                    'ktp_ayah',
                    $ayah->scan_ktp_ayah
                );
            }

            if ($request->hasFile('scan_ktp_ibu')) {
                $ibu->scan_ktp_ibu = UploadHelper::uploadFile(
                    $request->file('scan_ktp_ibu'),
                    'uploads/ktp_ibu',
                    'ktp_ibu',
                    $ibu->scan_ktp_ibu
                );
            }

            // Update the data for Ayah and Ibu
            $ayah->update([
                'nama_ayah_kandung' => $request->nama_ayah_kandung,
                'status_ayah_kandung' => $request->status_ayah_kandung,
                'nik_ayah' => $request->nik_ayah,
                'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
                'pendidikan_terakhir_ayah' => $request->pendidikan_terakhir_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'penghasilan_per_bulan_ayah' => $request->penghasilan_per_bulan_ayah,
                'alamat_ayah' => $request->alamat_ayah,
            ]);

            $ibu->update([
                'nama_ibu_kandung' => $request->nama_ibu_kandung,
                'status_ibu_kandung' => $request->status_ibu_kandung,
                'nik_ibu' => $request->nik_ibu,
                'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
                'pendidikan_terakhir_ibu' => $request->pendidikan_terakhir_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'penghasilan_per_bulan_ibu' => $request->penghasilan_per_bulan_ibu,
                'alamat_ibu' => $request->alamat_ibu,
            ]);

            DB::commit(); // Commit the transaction

            return response()->json([
                'success' => true,
                'message' => 'Data orang tua berhasil diperbarui.',
                'data' => [
                    'ayah' => $ayah,
                    'ibu' => $ibu
                ],
            ], 200); // 200 OK
        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback the transaction on failure
            Log::error('Update orang tua gagal: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data orang tua.',
            ], 500); // 500 Internal Server Error
        }
    }

    public function showWali($id)
    {
        try {
            $data = WaliSiswaBaru::where('siswa_baru_id', $id)->first();

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
            Log::error('Error saat mengambil data wali siswa baru: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateWali(Request $request, $id)
    {
        Log::debug('Updated data wali: ', $request->all());

        // Validasi input
        $request->validate([
            'nama_wali' => 'required|string|max:255',
            'scan_kk_wali' => $request->hasFile('scan_kk_wali') ? 'nullable|mimes:jpeg,jpg,png|max:2048' : 'nullable', // Validasi file KK Wali
            'scan_kartu_pkh' => $request->hasFile('scan_kartu_pkh') ? 'nullable|mimes:jpeg,jpg,png|max:2048' : 'nullable', // Validasi file Kartu PKH
            'scan_kartu_kks' => $request->hasFile('scan_kartu_kks') ? 'nullable|mimes:jpeg,jpg,png|max:2048' : 'nullable', // Validasi file Kartu KKS
        ]);

        // Cari data wali berdasarkan siswa_baru_id
        $wali = WaliSiswaBaru::where('siswa_baru_id', $id)->first();

        if (!$wali) {
            return response()->json([
                'success' => false,
                'message' => 'Data wali tidak ditemukan.',
            ], 404);
        }

        DB::beginTransaction();
        try {

            $file_name_kk = $wali->scan_kk_wali;
            $file_name_pkh = $wali->scan_kartu_pkh;
            $file_name_kks = $wali->scan_kartu_kks;

            if ($request->hasFile('scan_kk_wali')) {
                $file_name_kk = UploadHelper::uploadFile(
                    $request->file('scan_kk_wali'),
                    'uploads/scan_kk_wali',
                    'kk_wali',
                    $wali->scan_kk_wali
                );
            }

            if ($request->hasFile('scan_kartu_pkh')) {
                $file_name_pkh = UploadHelper::uploadFile(
                    $request->file('scan_kartu_pkh'),
                    'uploads/scan_kartu_pkh',
                    'kartu_pkh',
                    $wali->scan_kartu_pkh
                );
            }

            if ($request->hasFile('scan_kartu_kks')) {
                $file_name_kks = UploadHelper::uploadFile(
                    $request->file('scan_kartu_kks'),
                    'uploads/scan_kartu_kks',
                    'kartu_kks',
                    $wali->scan_kartu_kks
                );
            }

            $wali->update([
                'nama_wali' => $request->nama_wali,
                'scan_kk_wali' => $file_name_kk,
                'scan_kartu_pkh' => $file_name_pkh,
                'scan_kartu_kks' => $file_name_kks
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data wali berhasil diperbarui.',
                'data' => $wali,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            DB::rollBack();
            // Log error
            Log::error('Error saat memperbarui data wali: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data wali.',
            ], 500);
        }
    }

    public function showKeluarga($id)
    {
        try {
            $data = KeluargaSiswaBaru::where('siswa_baru_id', $id)->first();

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
            Log::error('Error saat mengambil data keluarga siswa baru: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateKeluarga(Request $request, $id)
    {
        // Validasi input form
        $validatedData = $request->validate([
            'nama_kepala_keluarga' => 'required|string|max:255',
            'nomor_kk' => 'required|string|regex:/\d{16}/', // Pastikan nomor KK 16 digit
            'alamat_rumah' => 'required|string|max:500',
            'yang_membiayai_sekolah' => 'required|in:ayah,ibu,wali',
        ]);
        // Cari data keluarga berdasarkan siswa_baru_id
        $keluarga = KeluargaSiswaBaru::where('siswa_baru_id', $id)->first();

        if (!$keluarga) {
            return response()->json([
                'success' => false,
                'message' => 'Data keluarga tidak ditemukan.',
            ], 404); // 404 Not Found
        }

        DB::beginTransaction();
        try {
            // Update data keluarga
            $keluarga->nama_kepala_keluarga = $request->nama_kepala_keluarga;
            $keluarga->nomor_kk = $request->nomor_kk;
            $keluarga->alamat_rumah = $request->alamat_rumah;
            $keluarga->yang_membiayai_sekolah = $request->yang_membiayai_sekolah;

            // Simpan perubahan
            $keluarga->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data status keluarga berhasil diperbarui.',
                'data' => $keluarga,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            DB::rollBack();
            // Log error
            Log::error('Error saat memperbarui data status keluarga: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data status keluarga.',
            ], 500); // 500 Internal Server Error
        }
    }

    public function updateStatusSiswa(Request $request, $id)
    {
        // Validasi input status siswa
        $validatedData = $request->validate([
            'status_siswa' => 'required|in:diterima,ditolak', // Pastikan status valid
        ]);

        // Cari data siswa berdasarkan id
        $siswa = SiswaBaru::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404); // 404 Not Found
        }

        DB::beginTransaction();

        try {
            // Update status siswa
            $siswa->status = $request->status_siswa;

            // Simpan perubahan
            $siswa->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status siswa berhasil diperbarui.',
                'data' => $siswa,
            ], 200); // 200 OK
        } catch (\Exception $e) {
            DB::rollBack();
            // Log error
            Log::error('Error saat memperbarui status siswa: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status siswa.',
            ], 500); // 500 Internal Server Error
        }
    }

    public function export(Request $request)
    {
        // Menangkap ID siswa yang dipilih dari request
        $selectedIds = $request->input('ids');

        // Mengecek apakah ada ID yang dipilih
        if (empty($selectedIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada siswa yang dipilih untuk diekspor.'
            ], 400); // Mengembalikan response JSON dengan status 400 (Bad Request)
        }

        // Menangkap pilihan data yang akan diekspor
        $includeIbu = filter_var($request->input('include_ibu', false), FILTER_VALIDATE_BOOLEAN);
        $includeAyah = filter_var($request->input('include_ayah', false), FILTER_VALIDATE_BOOLEAN);
        $includeWali = filter_var($request->input('include_wali', false), FILTER_VALIDATE_BOOLEAN);
        $includeKeluarga = filter_var($request->input('include_keluarga', false), FILTER_VALIDATE_BOOLEAN);

        try {
            // Menyiapkan nama file yang akan diunduh
            $fileName = 'data_siswa_baru.xlsx';

            // Menggunakan Laravel Excel untuk mendownload file langsung
            return Excel::download(new SiswaBaruExport(
                $selectedIds,
                $includeIbu,
                $includeAyah,
                $includeWali,
                $includeKeluarga
            ), $fileName);
        } catch (\Exception $e) {
            // Jika terjadi error, log error
            Log::error('Error saat export siswa: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'ids' => $selectedIds
            ]);

            // Mengembalikan response error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengekspor data siswa.',
                'error' => $e->getMessage()
            ], 500); // Status 500 (Internal Server Error)
        }
    }
}
