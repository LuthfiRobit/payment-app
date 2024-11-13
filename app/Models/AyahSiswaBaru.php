<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AyahSiswaBaru extends Model
{
    use HasFactory, HasUuids;

    // Menentukan nama tabel
    protected $table = 'ayah_siswa_baru';

    // Menentukan primary key menggunakan UUID
    protected $primaryKey = 'id_ayah_siswa_baru';

    // Menggunakan UUID sebagai primary key dan bukan auto increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';

    // Menentukan kolom yang boleh diisi (fillable)
    protected $fillable = [
        'id_ayah_siswa_baru',         // UUID id_ayah_siswa_baru
        'siswa_baru_id',
        'nama_ayah_kandung',
        'status_ayah_kandung',
        'nik_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'pendidikan_terakhir_ayah',
        'pekerjaan_ayah',
        'penghasilan_per_bulan_ayah',
        'alamat_ayah',
        'scan_ktp_ayah',              // Sesuaikan dengan nama kolom di migration
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
