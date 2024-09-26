<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RincianTagihan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rincian_tagihan';
    protected $primaryKey = 'id_rincian_tagihan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tagihan_id',
        'tagihan_siswa_id',
        'potongan_siswa_id',
        'besar_tagihan',
        'besar_potongan',
        'sisa_iuran',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get the tagihan that owns the RincianTagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id', 'id_tagihan');
    }

    /**
     * Get the tagihanSiswa that owns the RincianTagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihanSiswa(): BelongsTo
    {
        return $this->belongsTo(TagihanSiswa::class, 'tagihan_siswa_id', 'id_tagihan_siswa');
    }

    /**
     * Get the potonganSiswa that owns the RincianTagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function potonganSiswa(): BelongsTo
    {
        return $this->belongsTo(PotonganSiswa::class, 'potongan_siswa_id', 'id_potongan_siswa');
    }

    /**
     * Get all of the rincianTransaksi for the RincianTagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rincianTransaksi(): HasMany
    {
        return $this->hasMany(RincianTransaksi::class, 'rincian_tagihan_id', 'id_rincian_tagihan');
    }
}
