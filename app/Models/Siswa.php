<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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

    /**
     * Additional method
     */

    // Method untuk mendapatkan data siswa beserta tagihan
    public static function getSiswaWithTagihan($filters = [])
    {
        // Query Builder untuk mendapatkan data siswa beserta tagihan
        $query = DB::table('siswa')
            ->select('siswa.id_siswa', 'siswa.nama_siswa as nama_siswa', 'siswa.nis', 'siswa.kelas', 'siswa.status')
            ->leftJoin('tagihan_siswa', 'siswa.id_siswa', '=', 'tagihan_siswa.siswa_id')
            ->leftJoin('iuran', 'tagihan_siswa.iuran_id', '=', 'iuran.id_iuran')
            ->groupBy('siswa.id_siswa')
            ->orderBy('siswa.created_at', 'DESC');

        // Filter berdasarkan status jika ada
        if (!empty($filters['filter_status'])) {
            $query->where('siswa.status', $filters['filter_status']);
        }

        // Filter berdasarkan kelas jika ada
        if (!empty($filters['filter_kelas'])) {
            $query->where('siswa.kelas', $filters['filter_kelas']);
        }

        // Return data siswa beserta tagihan
        return $query->get();
    }

    public static function getSiswaWithPotongan($filters = [])
    {
        // Query Builder untuk mendapatkan data siswa beserta tagihan
        $query = DB::table('siswa')
            ->select(
                'siswa.id_siswa',
                'siswa.nama_siswa',
                'siswa.nis',
                'siswa.kelas',
                'siswa.status',
                DB::raw('GROUP_CONCAT(DISTINCT iuran.nama_iuran SEPARATOR ", ") as tagihan'),
                DB::raw('COALESCE(GROUP_CONCAT(DISTINCT potongan.nama_potongan SEPARATOR ", "), "tidak ada potongan") as potongan')
            )
            ->join('tagihan_siswa', 'tagihan_siswa.siswa_id', '=', 'siswa.id_siswa') // Menggunakan INNER JOIN
            ->leftJoin('iuran', 'tagihan_siswa.iuran_id', '=', 'iuran.id_iuran') // Masih LEFT JOIN untuk iuran
            ->leftJoin('potongan_siswa', 'potongan_siswa.siswa_id', '=', 'siswa.id_siswa') // LEFT JOIN untuk potongan
            ->leftJoin('potongan', 'potongan_siswa.potongan_id', '=', 'potongan.id_potongan') // LEFT JOIN untuk potongan
            ->groupBy('siswa.id_siswa')
            ->orderBy('siswa.created_at', 'DESC');


        // Filter berdasarkan kelas jika ada
        if (!empty($filters['filter_kelas'])) {
            $query->where('siswa.kelas', $filters['filter_kelas']);
        }

        // Filter berdasarkan potongan (apakah memiliki potongan atau tidak)
        if (isset($filters['filter_potongan'])) {
            if ($filters['filter_potongan'] == 'ada') {
                // Menampilkan siswa yang memiliki potongan
                $query->havingRaw('COUNT(potongan.id_potongan) > 0');
            } elseif ($filters['filter_potongan'] == 'tidak') {
                // Menampilkan siswa yang tidak memiliki potongan
                $query->havingRaw('COUNT(potongan.id_potongan) = 0');
            }
        }

        // Return data siswa beserta tagihan
        return $query->get();
    }

    public static function getSiswaWithTagihanByAkedemik($filters = [])
    {
        // Get the active academic year
        $activeAcademicYear = AppHelper::getActiveAcademicYear();

        // Query Builder untuk mendapatkan data siswa beserta tagihan
        $query = DB::table('siswa')
            ->select(
                'siswa.id_siswa',
                'siswa.nama_siswa',
                'siswa.nis',
                'siswa.kelas',
                'siswa.status',
                DB::raw('GROUP_CONCAT(DISTINCT iuran.nama_iuran SEPARATOR ", ") AS iuran'),
                DB::raw('COALESCE(GROUP_CONCAT(DISTINCT potongan.nama_potongan SEPARATOR ", "), "tidak ada potongan") AS potongan'),
                DB::raw('CASE WHEN COUNT(tagihan.id_tagihan) > 0 THEN "aktif" ELSE "tidak aktif" END AS aksi')
            )
            ->join('tagihan_siswa', 'tagihan_siswa.siswa_id', '=', 'siswa.id_siswa')
            ->leftJoin('iuran', 'tagihan_siswa.iuran_id', '=', 'iuran.id_iuran')
            ->leftJoin('potongan_siswa', 'potongan_siswa.siswa_id', '=', 'siswa.id_siswa')
            ->leftJoin('potongan', 'potongan_siswa.potongan_id', '=', 'potongan.id_potongan')
            ->leftJoin('tagihan', function ($join) use ($activeAcademicYear) {
                $join->on('tagihan.siswa_id', '=', 'siswa.id_siswa')
                    ->where('tagihan.tahun_akademik_id', '=', $activeAcademicYear->id_tahun_akademik);
            })
            ->groupBy('siswa.id_siswa')
            ->orderBy('siswa.created_at', 'DESC');

        // Filter berdasarkan kelas jika ada
        if (!empty($filters['filter_kelas'])) {
            $query->where('siswa.kelas', $filters['filter_kelas']);
        }

        // Filter berdasarkan potongan (apakah memiliki potongan atau tidak)
        if (isset($filters['filter_potongan'])) {
            if ($filters['filter_potongan'] == 'ada') {
                // Menampilkan siswa yang memiliki potongan
                $query->havingRaw('COUNT(potongan.id_potongan) > 0');
            } elseif ($filters['filter_potongan'] == 'tidak') {
                // Menampilkan siswa yang tidak memiliki potongan
                $query->havingRaw('COUNT(potongan.id_potongan) = 0');
            }
        }

        // Filter berdasarkan tagihan (apakah memiliki tagihan atau tidak)
        if (isset($filters['filter_tagihan'])) {
            if ($filters['filter_tagihan'] == 'ada') {
                // Menampilkan siswa yang memiliki tagihan
                $query->havingRaw('COUNT(tagihan.id_tagihan) > 0');
            } elseif ($filters['filter_tagihan'] == 'tidak') {
                // Menampilkan siswa yang tidak memiliki tagihan
                $query->havingRaw('COUNT(tagihan.id_tagihan) = 0');
            }
        }

        // Return data siswa beserta tagihan
        return $query->get();
    }
}
