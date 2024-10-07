<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Tagihan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tahun_akademik_id',
        'siswa_id',
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
     * Get the tahunAkademik that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }

    /**
     * Get the siswa that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }

    /**
     * Get all of the rincianTagihan for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rincianTagihan(): HasMany
    {
        return $this->hasMany(RincianTagihan::class, 'tagihan_id', 'id_tagihan');
    }

    /**
     * Get all of the transaksi for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'tagihan_ida', 'id_tagihan');
    }

    /**
     * Additional method
     */

    // Method untuk mendapatkan data tagihan berdasarkan tahun akademik
    public static function tagihanByTa($filters = [])
    {
        // Get the active academic year
        $activeAcademicYear = AppHelper::getActiveAcademicYear();

        // Memulai query untuk mendapatkan data tagihan dan siswa
        $query = DB::table('tagihan')
            ->select(
                'siswa.id_siswa',
                'siswa.nis',
                'siswa.nama_siswa',
                'siswa.kelas',
                'tagihan.id_tagihan',
                'tagihan.besar_tagihan',
                'tagihan.besar_potongan',
                'tagihan.total_tagihan',
                'tagihan.status',
                'tahun_akademik.tahun',
                'tahun_akademik.semester'
            )
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'tagihan.siswa_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'tagihan.tahun_akademik_id')
            ->where('tagihan.tahun_akademik_id', '=', $activeAcademicYear->id_tahun_akademik)
            ->orderBy('tagihan.created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if (!empty($filters['filter_status'])) {
            $query->where('tagihan.status', $filters['filter_status']);
        }

        // Filter berdasarkan kelas jika ada
        if (!empty($filters['filter_kelas'])) {
            $query->where('siswa.kelas', $filters['filter_kelas']);
        }

        // Mengurutkan berdasarkan tanggal dibuat dan mengembalikan hasil
        return $query->get();
    }
}
