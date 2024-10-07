<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
        'total_tagihan',
        'sisa_tagihan',
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

    /**
     * Additional method
     */

    // Method untuk mendapatkan data rincian tagihan berdasarkan tagihan id
    public static function getByTagihan($id_tagihan)
    {
        $query = DB::table('rincian_tagihan')
            ->leftJoin('tagihan_siswa', 'tagihan_siswa.id_tagihan_siswa', '=', 'rincian_tagihan.tagihan_siswa_id')
            ->leftJoin('iuran', 'iuran.id_iuran', '=', 'tagihan_siswa.iuran_id')
            ->leftJoin('potongan_siswa', 'potongan_siswa.id_potongan_siswa', '=', 'rincian_tagihan.potongan_siswa_id')
            ->leftJoin('potongan', 'potongan.id_potongan', '=', 'potongan_siswa.potongan_id')
            ->where('tagihan_id', $id_tagihan)
            ->select(
                'rincian_tagihan.tagihan_id',
                'iuran.nama_iuran',
                'rincian_tagihan.besar_tagihan',
                'potongan.nama_potongan',
                'potongan_siswa.potongan_persen',
                'rincian_tagihan.besar_potongan',
                'rincian_tagihan.total_tagihan',
                'rincian_tagihan.status'
            );

        return $query->get();
    }
}
