<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SiswaBaru extends Model
{
    use HasFactory, HasUuids;

    // Menentukan nama tabel (secara default Laravel akan mengambil nama plural dari model)
    protected $table = 'siswa_baru';

    // Menentukan primary key menggunakan UUID
    protected $primaryKey = 'id_siswa_baru';

    // Menggunakan UUID sebagai primary key dan bukan auto increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';

    // Menentukan kolom yang boleh diisi (fillable)
    protected $fillable = [
        'tahun_akademik_id',
        'no_registrasi',
        'nik',
        'nama_lengkap_siswa',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'usia_saat_mendaftar',
        'jumlah_saudara',
        'anak_ke',
        'nomor_peci',
        'nomor_hp_wa',
        'email',
        'jarak_dari_rumah_ke_sekolah',
        'perjalanan_ke_sekolah',
        'sekolah_sebelum_mi',
        'nama_ra_tk',
        'alamat_ra_tk',
        'foto_siswa',
        'imunisasi'
    ];

    // Menentukan tipe atribut untuk JSON cast
    protected $casts = [
        'imunisasi' => 'array', // Untuk kolom imunisasi yang diikuti
    ];

    /**
     * Get the tahunAkademik that owns the SiswaBaru
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }

    /**
     * Get the ibu associated with the SiswaBaru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ibu(): HasOne
    {
        return $this->hasOne(IbuSiswaBaru::class, 'siswa_baru_id', 'id_siswa_baru');
    }

    /**
     * Get the ayah associated with the SiswaBaru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ayah(): HasOne
    {
        return $this->hasOne(AyahSiswaBaru::class, 'siswa_baru_id', 'id_siswa_baru');
    }

    /**
     * Get the wali associated with the SiswaBaru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wali(): HasOne
    {
        return $this->hasOne(WaliSiswaBaru::class, 'siswa_baru_id', 'id_siswa_baru');
    }

    /**
     * Get the keluarga associated with the SiswaBaru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function keluarga(): HasOne
    {
        return $this->hasOne(KeluargaSiswaBaru::class, 'siswa_baru_id', 'id_siswa_baru');
    }

    public static function getData($filters = [])
    {
        $query = self::select(
            'siswa_baru.id_siswa_baru',
            'tahun_akademik.id_tahun_akademik', // Kolom yang benar dari tabel tahun_akademik
            'tahun_akademik.tahun',  // Kolom tahun dari tabel tahun_akademik
            'tahun_akademik.semester', // Kolom semester dari tabel tahun_akademik
            'siswa_baru.nama_lengkap_siswa',
            'siswa_baru.no_registrasi',
            'siswa_baru.nik',
            'siswa_baru.sekolah_sebelum_mi',
            'siswa_baru.usia_saat_mendaftar',
            'siswa_baru.status'
        )
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'siswa_baru.tahun_akademik_id') // Join menggunakan kolom yang benar
            ->orderBy('siswa_baru.created_at', 'DESC');

        // Filter berdasarkan tahun jika ada
        if (!empty($filters['filter_tahun'])) {
            $query->where('siswa_baru.tahun_akademik_id', $filters['filter_tahun']);
        }

        // Filter berdasarkan status jika ada
        if (!empty($filters['filter_status'])) {
            // Periksa jika nilai status adalah 'null', yang berarti belum diproses (filter untuk nilai null)
            if ($filters['filter_status'] === 'null') {
                $query->whereNull('siswa_baru.status');
            } else {
                // Jika ada status lain (diterima, ditolak, digenerate)
                $query->where('siswa_baru.status', $filters['filter_status']);
            }
        }

        return $query->get();
    }

    public static function getPendaftarToday()
    {
        return self::select('siswa_baru.no_registrasi', 'siswa_baru.nama_panggilan', 'siswa_baru.usia_saat_mendaftar', 'siswa_baru.status')
            // ->where('tahun_akademik_id',)
            ->whereDate('siswa_baru.created_at', today())
            ->orderBy('siswa_baru.created_at', 'DESC')
            ->limit(5)
            ->get();
    }
}
