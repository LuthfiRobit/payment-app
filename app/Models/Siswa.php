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

    // Menentukan kolom yang boleh diisi (fillable)
    protected $fillable = [
        'id_siswa',               // UUID id_siswa
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
        'kelas'
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
     * Count the number of Siswa with an 'aktif' status
     *
     * @return int
     */
    public static function countAktif()
    {
        return self::where('status', 'aktif')->count();
    }

    /**
     * Count Siswa with tagihan for a specific academic year
     *
     * @param int|null $tahunAkademik
     * @return int
     */
    public static function countWithTagihanForTahunAkademik($tahunAkademik = null)
    {
        return self::join('tagihan', 'siswa.id_siswa', '=', 'tagihan.siswa_id')
            ->where('tagihan.tahun_akademik_id', $tahunAkademik)
            ->count('siswa.id_siswa');
    }

    /**
     * Get Siswa data along with their tagihan, applying optional filters
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public static function getSiswaWithTagihan($filters = [])
    {
        // Query Builder to retrieve Siswa data along with tagihan
        $query = DB::table('siswa')
            ->select('siswa.id_siswa', 'siswa.nama_siswa as nama_siswa', 'siswa.nis', 'siswa.kelas', 'siswa.status')
            ->leftJoin('tagihan_siswa', 'siswa.id_siswa', '=', 'tagihan_siswa.siswa_id')
            ->leftJoin('iuran', 'tagihan_siswa.iuran_id', '=', 'iuran.id_iuran')
            ->groupBy('siswa.id_siswa')
            ->orderBy('siswa.created_at', 'DESC');

        // Filter by status if provided
        if (!empty($filters['filter_status'])) {
            $query->where('siswa.status', $filters['filter_status']);
        }

        // Filter by class if provided
        if (!empty($filters['filter_kelas'])) {
            $query->where('siswa.kelas', $filters['filter_kelas']);
        }

        // Return the retrieved Siswa data with tagihan
        return $query->get();
    }

    /**
     * Get Siswa data along with tagihan and potential discounts, applying optional filters
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public static function getSiswaWithPotongan($filters = [])
    {
        // Query Builder to retrieve Siswa data along with tagihan and active potongan
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
            ->join('tagihan_siswa', 'tagihan_siswa.siswa_id', '=', 'siswa.id_siswa') // Using INNER JOIN
            ->leftJoin('iuran', 'tagihan_siswa.iuran_id', '=', 'iuran.id_iuran') // LEFT JOIN for iuran
            ->leftJoin('potongan_siswa', function ($join) {
                $join->on('potongan_siswa.siswa_id', '=', 'siswa.id_siswa')
                    ->where('potongan_siswa.status', 'aktif'); // Filter for active potongan
            })
            ->leftJoin('potongan', 'potongan_siswa.potongan_id', '=', 'potongan.id_potongan') // LEFT JOIN for potongan
            ->groupBy('siswa.id_siswa')
            ->orderBy('siswa.created_at', 'DESC');

        // Filter by class if provided
        if (!empty($filters['filter_kelas'])) {
            $query->where('siswa.kelas', $filters['filter_kelas']);
        }

        // Filter by potongan (whether they have a discount or not)
        if (isset($filters['filter_potongan'])) {
            if ($filters['filter_potongan'] == 'ada') {
                // Show Siswa who have potongan
                $query->havingRaw('COUNT(potongan.id_potongan) > 0');
            } elseif ($filters['filter_potongan'] == 'tidak') {
                // Show Siswa who do not have potongan
                $query->havingRaw('COUNT(potongan.id_potongan) = 0');
            }
        }

        // Return the retrieved Siswa data along with tagihan and potongan
        return $query->get();
    }


    /**
     * Get Siswa data along with their tagihan filtered by the active academic year
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public static function getSiswaWithTagihanByAkedemik($filters = [])
    {
        // Get the active academic year
        $activeAcademicYear = AppHelper::getActiveAcademicYear();

        // Query Builder to retrieve Siswa data along with tagihan
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
            ->leftJoin('potongan_siswa', function ($join) {
                $join->on('potongan_siswa.siswa_id', '=', 'siswa.id_siswa')
                    ->where('potongan_siswa.status', 'aktif'); // Filter for active potongan
            })
            ->leftJoin('potongan', 'potongan_siswa.potongan_id', '=', 'potongan.id_potongan')
            ->leftJoin('tagihan', function ($join) use ($activeAcademicYear) {
                $join->on('tagihan.siswa_id', '=', 'siswa.id_siswa')
                    ->where('tagihan.tahun_akademik_id', '=', $activeAcademicYear->id_tahun_akademik);
            })
            ->groupBy('siswa.id_siswa')
            ->orderBy('siswa.created_at', 'DESC');

        // Filter by class if provided
        if (!empty($filters['filter_kelas'])) {
            $query->where('siswa.kelas', $filters['filter_kelas']);
        }

        // Filter by potongan (whether they have a discount or not)
        if (isset($filters['filter_potongan'])) {
            if ($filters['filter_potongan'] == 'ada') {
                // Show Siswa who have potongan
                $query->havingRaw('COUNT(potongan.id_potongan) > 0');
            } elseif ($filters['filter_potongan'] == 'tidak') {
                // Show Siswa who do not have potongan
                $query->havingRaw('COUNT(potongan.id_potongan) = 0');
            }
        }

        // Filter by tagihan (whether they have tagihan or not)
        if (isset($filters['filter_tagihan'])) {
            if ($filters['filter_tagihan'] == 'ada') {
                // Show Siswa who have tagihan
                $query->havingRaw('COUNT(tagihan.id_tagihan) > 0');
            } elseif ($filters['filter_tagihan'] == 'tidak') {
                // Show Siswa who do not have tagihan
                $query->havingRaw('COUNT(tagihan.id_tagihan) = 0');
            }
        }

        // Return the retrieved Siswa data along with tagihan
        return $query->get();
    }
}
