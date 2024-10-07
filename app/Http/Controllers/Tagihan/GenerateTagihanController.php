<?php

namespace App\Http\Controllers\Tagihan;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\RincianTagihan;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TagihanSiswa;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class GenerateTagihanController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index()
    {
        return view('tagihan.generate.views.index');
    }

    public function getData(Request $request)
    {
        // Menyiapkan filter dari request
        $filters = [
            'filter_kelas' => $request->input('filter_kelas', ''),
            'filter_potongan' => $request->input('filter_potongan', ''),
            'filter_tagihan' => $request->input('filter_tagihan', ''), // Tambahkan filter untuk tagihan jika perlu
        ];

        // Mengambil data siswa beserta tagihan dan potongan dari model
        $query = Siswa::getSiswaWithTagihanByAkedemik($filters);

        // Mengambil data dengan Yajra DataTables
        return DataTables::of($query)
            ->addColumn('checkbox', function ($item) {
                $disabled = $item->aksi == 'aktif' ? 'disabled' : '';
                return '<input type="checkbox" class="siswa-checkbox form-check-input" value="' . $item->id_siswa . '" ' . $disabled . '>';
            })
            ->addColumn('siswa', function ($item) {
                return strtoupper($item->nis . ' - ' . $item->nama_siswa); // Mengubah NIS dan nama siswa menjadi uppercase
            })
            ->addColumn('kelas', function ($item) {
                return strtoupper($item->kelas); // Mengubah kelas menjadi uppercase
            })
            ->addColumn('iuran', function ($item) {
                return strtoupper($item->iuran ?: 'BELUM ADA IURAN'); // Mengubah iuran menjadi uppercase
            })
            ->addColumn('potongan', function ($item) {
                return strtoupper($item->potongan ?: 'TIDAK ADA POTONGAN'); // Mengubah potongan menjadi uppercase
            })
            ->rawColumns(['checkbox'])
            ->make(true);
    }

    public function storeMultiple(Request $request)
    {
        // Get the active academic year
        $activeAcademicYear = AppHelper::getActiveAcademicYear();

        // Ambil id_tahun_akademik dari tahun akademik aktif
        $tahunAkademikId = $activeAcademicYear->id_tahun_akademik;

        // Validasi input
        $request->validate([
            'siswa_ids' => 'required|array',
        ], [
            'siswa_ids.required' => 'Daftar siswa wajib diisi.',
        ]);

        $siswaIds = $request->siswa_ids;

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            foreach ($siswaIds as $siswaId) {
                // Ambil tagihan siswa untuk siswa yang dipilih
                $tagihanSiswaList = TagihanSiswa::where([
                    ['siswa_id', $siswaId],
                    ['status', 'aktif']
                ])->get();

                // Buat entri tagihan baru
                $tagihan = Tagihan::create([
                    'id_tagihan' => Str::uuid(),
                    'tahun_akademik_id' => $tahunAkademikId,
                    'siswa_id' => $siswaId,
                    'besar_tagihan' => 0, // Inisialisasi
                    'besar_potongan' => 0, // Inisialisasi
                    'total_tagihan' => 0, // Inisialisasi
                    'sisa_tagihan' => 0, // Inisialisasi
                    'status' => 'belum lunas',
                ]);

                $totalBesarTagihan = 0;
                $totalBesarPotongan = 0;

                foreach ($tagihanSiswaList as $tagihanSiswa) {
                    // Ambil potongan siswa yang aktif
                    $potonganSiswa = $tagihanSiswa->potonganSiswa()->where('status', 'aktif')->first();

                    $besarIuran = $tagihanSiswa->iuran->besar_iuran; // Misalkan ini ada di model TagihanSiswa
                    $currentBesarPotongan = 0;

                    // Hitung potongan jika ada potongan siswa yang aktif
                    if ($potonganSiswa) {
                        $currentBesarPotongan = ($besarIuran * $potonganSiswa->potongan_persen) / 100;
                    }

                    // Hitung sisa iuran
                    $totalRincian = $besarIuran - $currentBesarPotongan;
                    $statusRincian = $totalRincian == 0 ? 'lunas' : 'belum lunas';

                    // Simpan rincian tagihan
                    RincianTagihan::create([
                        'id_rincian_tagihan' => Str::uuid(),
                        'tagihan_id' => $tagihan->id_tagihan,
                        'tagihan_siswa_id' => $tagihanSiswa->id_tagihan_siswa,
                        'potongan_siswa_id' => $potonganSiswa->id_potongan_siswa ?? null, // Atur ke null jika tidak ada potongan
                        'besar_tagihan' => $besarIuran,
                        'besar_potongan' => $currentBesarPotongan, // Ini bisa 0 jika tidak ada potongan
                        'total_tagihan' => $totalRincian,
                        'sisa_tagihan' => $totalRincian,
                        'status' => $statusRincian,
                    ]);

                    // Akumulasi total tagihan dan potongan
                    $totalBesarTagihan += $besarIuran;
                    $totalBesarPotongan += $currentBesarPotongan;
                }

                // Update tagihan dengan total yang dihitung
                $totalTagihan = $totalBesarTagihan - $totalBesarPotongan;
                $statusTagihan = $totalTagihan == 0 ? 'lunas' : 'belum lunas';

                $tagihan->update([
                    'besar_tagihan' => $totalBesarTagihan,
                    'besar_potongan' => $totalBesarPotongan,
                    'total_tagihan' => $totalTagihan,
                    'sisa_tagihan' => $totalTagihan,
                    'status' => $statusTagihan,
                ]);
            }

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            // Kembalikan respon sukses
            return $this->responseService->successResponse('Tagihan berhasil dibuat untuk siswa yang dipilih!', [], []);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Log kesalahan untuk debugging
            Log::error('Error saat generate tagihan: ' . $e->getMessage());

            // Kembalikan respon error
            return $this->responseService->errorResponse('Terjadi kesalahan saat menghasilkan tagihan.', $e->getMessage());
        }
    }
}
