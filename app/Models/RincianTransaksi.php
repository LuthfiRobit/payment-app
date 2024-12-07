<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class RincianTransaksi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rincian_transaksi';
    protected $primaryKey = 'id_rincian_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'transaksi_id',
        'rincian_tagihan_id',
        'total_bayar',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get the transaksi that owns the RincianTransaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id_transaksi');
    }

    /**
     * Get the rincianTagihan that owns the RincianTransaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rincianTagihan(): BelongsTo
    {
        return $this->belongsTo(RincianTagihan::class, 'rincian_tagihan_id', 'id_rincian_tagihan');
    }

    /**
     * Additional method
     */
    // Method untuk mendapatkan data rincian transaksi by id transaksi
    public static function getDataByIdTransaksi($transaksi_id)
    {
        $query = DB::table('rincian_transaksi')
            ->leftJoin(
                'rincian_tagihan',
                'rincian_tagihan.id_rincian_tagihan',
                '=',
                'rincian_transaksi.rincian_tagihan_id'
            )
            ->leftJoin('tagihan_siswa', 'tagihan_siswa.id_tagihan_siswa', '=', 'rincian_tagihan.tagihan_siswa_id')
            ->leftJoin('iuran', 'iuran.id_iuran', '=', 'tagihan_siswa.iuran_id')
            ->where('rincian_transaksi.transaksi_id', $transaksi_id)
            ->select(
                'rincian_transaksi.total_bayar',
                'iuran.nama_iuran',
                'rincian_tagihan.total_tagihan',
                'rincian_tagihan.status'
            );

        return $query->get();
    }

    public static function getRincianTransaksiSetoran($filters = [])
    {
        // Set default filter untuk tahun dan bulan jika tidak diberikan
        $tahun = $filters['filter_tahun'] ?? date('Y'); // Default ke tahun saat ini
        $bulan = $filters['filter_bulan'] ?? date('m'); // Default ke bulan saat ini

        // Mengambil data rincian transaksi berdasarkan filter created_at
        $rincianTransaksi = DB::table('rincian_transaksi')
            ->select(
                'iuran.id_iuran',
                'iuran.nama_iuran',
                DB::raw('SUM(rincian_transaksi.total_bayar) AS total_bayar')
            )
            ->join('rincian_tagihan', 'rincian_transaksi.rincian_tagihan_id', '=', 'rincian_tagihan.id_rincian_tagihan')
            ->join('tagihan_siswa', 'rincian_tagihan.tagihan_siswa_id', '=', 'tagihan_siswa.id_tagihan_siswa')
            ->join('iuran', 'tagihan_siswa.iuran_id', '=', 'iuran.id_iuran')
            // Menggunakan filter untuk tahun dan bulan pada created_at di rincian_transaksi
            ->whereYear('rincian_transaksi.created_at', '=', $tahun)
            ->whereMonth('rincian_transaksi.created_at', '=', $bulan)
            ->groupBy(
                'iuran.id_iuran',
                'iuran.nama_iuran'
            )
            ->get();

        // Ambil data setoran_keuangan berdasarkan tahun dan bulan
        $setoranKeuangan = DB::table('setoran_keuangan')
            ->select('id_setoran_keuangan')
            ->whereYear('created_at', '=', $tahun) // Filter berdasarkan tahun
            ->whereMonth('created_at', '=', $bulan) // Filter berdasarkan bulan
            ->get();

        // Jika ada data setoran_keuangan, ambil rincian_setoran berdasarkan setoran_keuangan_id
        $rincianSetoran = DB::table('rincian_setoran')
            ->select(
                'rincian_setoran.iuran_id',
                'rincian_setoran.total_setoran',
                'rincian_setoran.sisa_setoran',
                'rincian_setoran.status'
            )
            ->whereIn('rincian_setoran.setoran_keuangan_id', $setoranKeuangan->pluck('id_setoran_keuangan'))
            ->get();

        // Gabungkan data rincian_setoran dengan rincian_transaksi
        foreach ($rincianTransaksi as $rincian) {
            // Cek dan tambahkan data rincian_setoran terkait
            $setoran = $rincianSetoran->where('iuran_id', $rincian->id_iuran)->first();

            // Jika ada rincian_setoran terkait, masukkan data total_setoran dan sisa_setoran
            if ($setoran) {
                $rincian->total_setoran = (int) ($setoran->total_setoran ?? 0); // Pastikan integer
                $rincian->sisa_setoran = (int) ($setoran->sisa_setoran ?? 0); // Pastikan integer
                $rincian->rincian_status = $setoran->status ?? 'belum lunas';
            } else {
                // Jika tidak ada rincian_setoran terkait, set default value
                $rincian->total_setoran = 0;
                $rincian->sisa_setoran = 0;
                $rincian->rincian_status = 'belum lunas';
            }
        }

        // Menambahkan field "harus_dibayar"
        foreach ($rincianTransaksi as $rincian) {
            // Ganti null dengan 0 jika sisa_setoran atau total_setoran null
            $rincian->sisa_setoran = (int) ($rincian->sisa_setoran ?? 0); // Pastikan integer
            $rincian->total_setoran = (int) ($rincian->total_setoran ?? 0); // Pastikan integer

            // Tentukan nilai "harus_dibayar" berdasarkan kondisi
            $rincian->harus_dibayar = (int) ($rincian->sisa_setoran > 0 ? $rincian->sisa_setoran : $rincian->total_bayar); // Pastikan integer
        }

        // Kembalikan hasilnya
        return $rincianTransaksi;
    }
}
