<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
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
}
