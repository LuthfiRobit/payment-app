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

    /**
     * Konstruktor untuk menginisialisasi ResponseService.
     *
     * @param \App\Services\ResponseService $responseService
     */
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    /**
     * Menampilkan halaman index pembayaran dengan data tahun akademik.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil data tahun akademik
        $tahunAkademik = TahunAkademik::select('id_tahun_akademik', 'tahun', 'semester')->get();

        // Mengembalikan tampilan index pembayaran dengan data tahun akademik
        return view('transaksi.pembayaran.views.index', compact('tahunAkademik'));
    }

    /**
     * Menampilkan detail tagihan berdasarkan filter tahun dan siswa.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Menyimpan transaksi pembayaran beserta rincian pembayaran dan memperbarui tagihan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi Input
            $this->validateRequest($request);

            // Validasi rincian pembayaran dan hitung total bayar
            $totalBayar = $this->validateRincian($request->rincian);

            // Validasi tagihan utama
            $this->validateTagihan($request->tagihan_id, $totalBayar);

            // Buat entri transaksi baru
            $transaksi = $this->createTransaksi($request);

            // Proses rincian pembayaran
            $semuaLunas = $this->processRincian($request->rincian, $transaksi->id_transaksi);

            // Update status tagihan utama
            $this->updateTagihan($request->tagihan_id, $semuaLunas);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil disimpan dan tagihan diperbarui!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan pembayaran: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Memvalidasi data request untuk transaksi pembayaran.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    private function validateRequest(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id_siswa',
            'tagihan_id' => 'required|exists:tagihan,id_tagihan',
            'rincian' => 'required|array',
            'rincian.*.rincian_tagihan_id' => 'required|exists:rincian_tagihan,id_rincian_tagihan',
            'rincian.*.total_bayar' => 'required|numeric|min:0',
        ]);
    }

    /**
     * Memvalidasi rincian pembayaran dan menghitung total pembayaran.
     *
     * @param array $rincian
     * @throws \Exception
     * @return float
     */
    private function validateRincian(array $rincian)
    {
        $rincianIds = array_column($rincian, 'rincian_tagihan_id');
        $rincianTagihanData = RincianTagihan::whereIn('id_rincian_tagihan', $rincianIds)->get()->keyBy('id_rincian_tagihan');
        $totalBayar = 0;

        foreach ($rincian as $rincianItem) {
            $rincianTagihan = $rincianTagihanData[$rincianItem['rincian_tagihan_id']] ?? null;

            if (!$rincianTagihan) {
                throw new \Exception("Rincian tagihan dengan ID {$rincianItem['rincian_tagihan_id']} tidak ditemukan.");
            }

            if ($rincianItem['total_bayar'] > $rincianTagihan->sisa_tagihan) {
                throw new \Exception("Pembayaran untuk rincian tagihan ID {$rincianTagihan->id_rincian_tagihan} melebihi sisa tagihan.");
            }

            $totalBayar += $rincianItem['total_bayar'];
        }

        return $totalBayar;
    }

    /**
     * Memvalidasi tagihan utama untuk memastikan pembayaran tidak melebihi sisa tagihan.
     *
     * @param string $tagihanId
     * @param float $totalBayar
     * @throws \Exception
     * @return \App\Models\Tagihan
     */
    private function validateTagihan(string $tagihanId, float $totalBayar)
    {
        $tagihan = Tagihan::find($tagihanId);

        if (!$tagihan) {
            throw new \Exception("Tagihan dengan ID {$tagihanId} tidak ditemukan.");
        }

        if ($totalBayar > $tagihan->sisa_tagihan) {
            throw new \Exception("Pembayaran total melebihi sisa tagihan utama.");
        }

        return $tagihan;
    }

    /**
     * Membuat entri transaksi baru di database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Transaksi
     */
    private function createTransaksi(Request $request)
    {
        $uniqueId = (string) Str::uuid();
        $timestamp = Carbon::now()->format('ymd');
        $nomorTransaksi = 'TRX-' . $timestamp . '-' . substr($uniqueId, 0, 5);

        return Transaksi::create([
            'nomor_transaksi' => $nomorTransaksi,
            'siswa_id' => $request->siswa_id,
            'tagihan_id' => $request->tagihan_id,
            'jumlah_bayar' => 0,
            'tanggal_bayar' => Carbon::now(),
            'status' => $request->status ?? 'sukses',
        ]);
    }

    /**
     * Memproses rincian pembayaran dan memperbarui status tagihan terkait.
     *
     * @param array $rincian
     * @param string $transaksiId
     * @return bool
     */
    private function processRincian(array $rincian, string $transaksiId)
    {
        $semuaLunas = true;
        $totalBayar = 0;

        foreach ($rincian as $rincianItem) {
            $rincianTagihan = RincianTagihan::find($rincianItem['rincian_tagihan_id']);

            $rincianTagihan->sisa_tagihan -= $rincianItem['total_bayar'];
            $rincianTagihan->status = $rincianTagihan->sisa_tagihan == 0 ? 'lunas' : 'belum lunas';
            $rincianTagihan->save();

            RincianTransaksi::create([
                'transaksi_id' => $transaksiId,
                'rincian_tagihan_id' => $rincianItem['rincian_tagihan_id'],
                'total_bayar' => $rincianItem['total_bayar'],
            ]);

            if ($rincianTagihan->sisa_tagihan > 0) {
                $semuaLunas = false;
            }
            $totalBayar += $rincianItem['total_bayar'];
        }

        // Update jumlah bayar pada transaksi
        Transaksi::where('id_transaksi', $transaksiId)
            ->update(['jumlah_bayar' => $totalBayar]);

        return $semuaLunas;
    }

    /**
     * Memperbarui tagihan utama setelah pembayaran dilakukan.
     *
     * @param string $tagihanId
     * @param bool $semuaLunas
     * @return void
     */
    private function updateTagihan(string $tagihanId, bool $semuaLunas)
    {
        $tagihan = Tagihan::find($tagihanId);
        $tagihan->sisa_tagihan = $tagihan->rincianTagihan()->sum('sisa_tagihan');
        $tagihan->status = $semuaLunas ? 'lunas' : 'belum lunas';
        $tagihan->save();
    }
}
