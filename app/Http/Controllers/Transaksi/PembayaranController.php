<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\RincianTagihan;
use App\Models\RincianTransaksi;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TahunAkademik;
use App\Models\Transaksi;
use App\Services\ResponseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    protected $responseService;

    // Konstruktor untuk menginisialisasi ResponseService
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    // Menampilkan halaman index pembayaran
    public function index()
    {
        // Mengambil data tahun akademik
        $tahunAkademik = TahunAkademik::select('id_tahun_akademik', 'tahun', 'semester')->get();

        // Mengembalikan tampilan index pembayaran dengan data tahun akademik
        return view('transaksi.pembayaran.views.index', compact('tahunAkademik'));
    }

    // Menampilkan detail tagihan berdasarkan filter yang diberikan
    public function show(Request $request)
    {
        // Mengambil filter tahun dan siswa dari request
        $idTahun = $request->input('filter_tahun');
        $idSiswa = $request->input('filter_siswa');

        try {
            // Mencari data tagihan berdasarkan ID yang diberikan
            $tagihan = Tagihan::where([['tahun_akademik_id', $idTahun], ['siswa_id', $idSiswa]])->first();

            // Jika data tagihan tidak ditemukan, kembalikan response 404
            if (!$tagihan) {
                return $this->responseService->notFoundResponse('Data tagihan tidak ditemukan');
            }

            // Mengambil data siswa berdasarkan ID siswa yang terdapat di dalam tagihan
            $siswa = Siswa::where('id_siswa', $tagihan->siswa_id)
                ->select('id_siswa', 'nis', 'nama_siswa', 'kelas', 'nomor_telepon')->first();

            // Mengambil rincian tagihan menggunakan metode yang sudah didefinisikan sebelumnya
            $rincianTagihan = RincianTagihan::getByTagihan($tagihan->id_tagihan);

            // Jika data tagihan ditemukan, kembalikan response sukses dengan data tagihan, siswa, dan rincian
            return $this->responseService->successResponse('Data tagihan berhasil ditemukan', $tagihan, [
                'siswa' => $siswa,
                'rincian' => $rincianTagihan // Menambahkan rincian tagihan ke dalam response
            ]);
        } catch (\Exception $e) {
            // Logging kesalahan untuk debugging
            Log::error('Error saat mengambil data tagihan: ' . $e->getMessage());

            // Mengembalikan response error jika terjadi exception
            return $this->responseService->errorResponse('Terjadi kesalahan saat mengambil data tagihan', $e->getMessage());
        }
    }

    // Menyimpan data pembayaran
    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $this->validateRequest($request);

        // Memulai transaksi database
        DB::beginTransaction();

        try {
            // Membuat entri baru di tabel Transaksi
            $transaksi = $this->createTransaksi($request);

            // Memproses rincian pembayaran dan memeriksa apakah semuanya telah dilunasi
            $semuaLunas = $this->processRincian($request->rincian, $transaksi->id_transaksi);

            // Memperbarui status tagihan berdasarkan pembayaran yang dilakukan
            $this->updateTagihan($request->tagihan_id, $request->jumlah_bayar, $semuaLunas);

            // Mengkomit transaksi jika semua operasi berhasil
            DB::commit();

            // Mengembalikan respons sukses
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil disimpan dan tagihan diperbarui!']);
        } catch (\Exception $e) {
            // Mengembalikan transaksi jika terjadi kesalahan
            DB::rollBack();
            Log::error('Error saat menyimpan pembayaran dan memperbarui tagihan: ' . $e->getMessage());

            // Mengembalikan respons error
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan pembayaran atau memperbarui tagihan.'], 500);
        }
    }

    /**
     * Validasi input request
     *
     * @param Request $request
     */
    private function validateRequest(Request $request)
    {
        // Validasi input untuk memastikan data yang diterima sesuai
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id_siswa',
            'tagihan_id' => 'required|exists:tagihan,id_tagihan',
            'jumlah_bayar' => 'required|numeric|min:0',
            'rincian' => 'required|array',
            'rincian.*.rincian_tagihan_id' => 'required|exists:rincian_tagihan,id_rincian_tagihan',
            'rincian.*.total_bayar' => 'required|numeric|min:0',
        ]);
    }

    /**
     * Membuat entri transaksi baru
     *
     * @param Request $request
     * @return Transaksi
     */
    private function createTransaksi(Request $request)
    {
        // Generate nomor transaksi menggunakan UUID
        $uniqueId = (string) Str::uuid(); // Menghasilkan UUID
        $timestamp = Carbon::now()->format('ymd'); // Format YYMMDD
        $nomorTransaksi = 'TRX-' . $timestamp . '-' . substr($uniqueId, 0, 5); // Mengambil 5 karakter dari UUID

        // Membuat entri transaksi baru
        return Transaksi::create([
            'nomor_transaksi' => $nomorTransaksi,
            'siswa_id' => $request->siswa_id,
            'tagihan_id' => $request->tagihan_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => Carbon::now(),
            'status' => $request->status ?? 'sukses', // Default ke 'sukses' jika status tidak disediakan
        ]);
    }

    /**
     * Memproses rincian pembayaran
     *
     * @param array $rincian
     * @param string $transaksiId
     * @return bool
     */
    private function processRincian(array $rincian, string $transaksiId)
    {
        // Variabel untuk melacak apakah semua rincian telah dilunasi
        $semuaLunas = true;

        foreach ($rincian as $rincianItem) {
            // Membuat entri rincian transaksi baru
            $rincianTransaksi = RincianTransaksi::create([
                'transaksi_id' => $transaksiId,
                'rincian_tagihan_id' => $rincianItem['rincian_tagihan_id'],
                'total_bayar' => $rincianItem['total_bayar'],
            ]);

            // Memperbarui rincian tagihan
            $rincianTagihan = RincianTagihan::find($rincianItem['rincian_tagihan_id']);
            $rincianTagihan->sisa_tagihan -= $rincianItem['total_bayar'];
            $rincianTagihan->status = $rincianTagihan->sisa_tagihan == 0 ? 'lunas' : 'belum lunas';
            $rincianTagihan->save();

            // Memeriksa status rincian tagihan
            if ($rincianTagihan->status === 'belum lunas') {
                $semuaLunas = false;
            }
        }

        return $semuaLunas;
    }

    /**
     * Memperbarui status dan sisa tagihan
     *
     * @param string $tagihanId
     * @param float $jumlahBayar
     * @param bool $semuaLunas
     */
    private function updateTagihan(string $tagihanId, float $jumlahBayar, bool $semuaLunas)
    {
        // Memperbarui status dan sisa tagihan
        $tagihan = Tagihan::find($tagihanId);
        $tagihan->sisa_tagihan -= $jumlahBayar;
        $tagihan->status = $semuaLunas ? 'lunas' : 'belum lunas';
        $tagihan->save();
    }
}
