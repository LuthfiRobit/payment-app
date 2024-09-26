<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PotonganSiswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'potongan_siswa';
    protected $primaryKey = 'id_potongan_siswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'siswa_id',
        'tagihan_siswa_id',
        'potongan_id',
        'potongan_persen',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get the siswa that owns the PotonganSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }

    /**
     * Get the tagihanSiswa that owns the PotonganSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihanSiswa(): BelongsTo
    {
        return $this->belongsTo(TagihanSiswa::class, 'tagihan_siswa_id', 'id_tagihan_siswa');
    }

    /**
     * Get the potongan that owns the PotonganSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function potongan(): BelongsTo
    {
        return $this->belongsTo(Potongan::class, 'potongan_id', 'id_potongan');
    }

    /**
     * Get all of the rincianTagihan for the PotonganSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rincianTagihan(): HasMany
    {
        return $this->hasMany(RincianTagihan::class, 'potongan_siswa_id', 'id_potongan_siswa');
    }
}
