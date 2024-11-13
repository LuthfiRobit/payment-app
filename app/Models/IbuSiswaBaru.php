<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IbuSiswaBaru extends Model
{
    use HasFactory, HasUuids;

    // Menentukan nama tabel
    protected $table = 'ibu_siswa_baru';

    // Menentukan primary key menggunakan UUID
    protected $primaryKey = 'id_ibu_siswa_baru';

    // Menggunakan UUID sebagai primary key dan bukan auto increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';

    // Menentukan kolom yang boleh diisi (fillable)
    protected $fillable = [
        'id_ibu_siswa_baru',         // UUID id_ibu_siswa_baru
        'siswa_baru_id',
        'nama_ibu_kandung',
        'status_ibu_kandung',
        'nik_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pendidikan_terakhir_ibu',
        'pekerjaan_ibu',
        'penghasilan_per_bulan_ibu',
        'alamat_ibu',
        'scan_ktp_ibu',              // Sesuaikan dengan nama kolom di migration
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
