<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
