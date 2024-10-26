<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Transaksi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nomor_transaksi',
        'siswa_id',
        'tagihan_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get the siswa that owns the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }

    /**
     * Get the tagihan that owns the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id', 'id_tagihan');
    }

    /**
     * Get all of the rincianTransaksi for the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rincianTransaksi(): HasMany
    {
        return $this->hasMany(RincianTransaksi::class, 'transaksi_id', 'id_transaksi');
    }

    /**
     * Additional method
     */

    /**
     * Calculate the total jumlah_bayar for today's transactions
     *
     * @return float
     */
    public static function totalJumlahBayarToday()
    {
        return self::whereDate('tanggal_bayar', today())
            ->sum('jumlah_bayar');
    }

    public static function getTransaksiToday()
    {
        return self::select('transaksi.nomor_transaksi', 'transaksi.jumlah_bayar', 'siswa.nis', 'siswa.nama_siswa')
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'transaksi.siswa_id')
            ->whereDate('transaksi.tanggal_bayar', today())
            ->orderBy('transaksi.tanggal_bayar', 'DESC')
            ->limit(5)
            ->get();
    }

    public static function getTransaksiWeekly()
    {
        return self::select(DB::raw('DATE(tanggal_bayar) as date'), DB::raw('SUM(jumlah_bayar) as total_bayar'))
            ->where('tanggal_bayar', '>=', now()->subDays(6)) // Last 7 days including today
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    // Method untuk mendapatkan data transaksi dengan filter yang diberikan
    public static function getTransaksiWithFilters($filters = [])
    {
        // Memulai query untuk mendapatkan data transaksi, siswa, tagihan, dan tahun akademik
        $query = DB::table('transaksi')
            ->select(
                'transaksi.id_transaksi',
                'transaksi.nomor_transaksi',
                'transaksi.siswa_id',
                'transaksi.jumlah_bayar',
                'transaksi.tanggal_bayar',
                'transaksi.status',
                'siswa.nama_siswa',
                'siswa.nis',
                'tahun_akademik.tahun',
                'tahun_akademik.semester'
            )
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'transaksi.siswa_id')
            ->leftJoin('tagihan', 'tagihan.id_tagihan', '=', 'transaksi.tagihan_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'tagihan.tahun_akademik_id')
            ->orderBy('transaksi.created_at', 'DESC');

        // Filter berdasarkan tahun akademik ID jika ada
        if (!empty($filters['filter_tahun'])) {
            $query->where('tagihan.tahun_akademik_id', $filters['filter_tahun']);
        }

        // Filter berdasarkan siswa ID jika ada
        if (!empty($filters['filter_siswa'])) {
            $query->where('transaksi.siswa_id', $filters['filter_siswa']);
        }

        // Filter berdasarkan tanggal bayar jika ada
        if (!empty($filters['filter_tanggal'])) {
            $query->whereDate('transaksi.tanggal_bayar', $filters['filter_tanggal']);
        }

        // Mengembalikan hasil
        return $query->get();
    }
}
