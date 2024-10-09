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
}
