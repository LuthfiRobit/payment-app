<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaliSiswaBaru extends Model
{
    use HasFactory, HasUuids;

    // Menentukan nama tabel
    protected $table = 'wali_siswa_baru';

    // Menentukan primary key menggunakan UUID
    protected $primaryKey = 'id_wali_siswa_baru';

    // Menggunakan UUID sebagai primary key dan bukan auto increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';

    // Menentukan kolom yang boleh diisi (fillable)
    protected $fillable = [
        'id_wali_siswa_baru',         // UUID id_wali_siswa_baru
        'siswa_baru_id',
        'nama_wali',
        'scan_kk_wali',
        'scan_kartu_pkh',
        'scan_kartu_kks',
    ];


    /**
     * Get the siswaBaru that owns the IbuSiswaBaru
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswaBaru(): BelongsTo
    {
        return $this->belongsTo(SiswaBaru::class, 'siswa_baru_id', 'id_siswa_baru');
    }
}