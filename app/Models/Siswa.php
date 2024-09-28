<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'nis',
        'nama_siswa',
        'status',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'nomor_telepon',
        'email',
        'kelas',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get the user that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    /**
     * Get all of the tagihanSiswa for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihanSiswa(): HasMany
    {
        return $this->hasMany(TagihanSiswa::class, 'siswa_id', 'id_siswa');
    }

    /**
     * Get all of the potonganSiswa for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function potonganSiswa(): HasMany
    {
        return $this->hasMany(PotonganSiswa::class, 'siswa_id', 'id_siswa');
    }

    /**
     * Get all of the tagihan for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class, 'siswa_id', 'id_siswa');
    }

    /**
     * Get all of the transaksi for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'siswa_id', 'id_siswa');
    }
}
