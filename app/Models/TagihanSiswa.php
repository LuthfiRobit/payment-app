<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TagihanSiswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tagihan_siswa';
    protected $primaryKey = 'id_tagihan_siswa';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'siswa_id',
        'iuran_id',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get the siswa that owns the TagihanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }

    /**
     * Get the iuran that owns the TagihanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function iuran(): BelongsTo
    {
        return $this->belongsTo(Iuran::class, 'iuran_id', 'id_iuran');
    }

    /**
     * Get all of the rincianTagihan for the TagihanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rincianTagihan(): HasMany
    {
        return $this->hasMany(RincianTagihan::class, 'tagihan_siswa_id', 'id_tagihan_siswa');
    }
}
