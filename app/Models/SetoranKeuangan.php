<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetoranKeuangan extends Model
{
    use HasFactory, HasUuids;

    /**
     * @var string
     */
    protected $table = 'setoran_keuangan';

    /**
     * @var string
     */
    protected $primaryKey = 'id_setoran_keuangan';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array
     */
    protected $fillable = [
        'bulan',
        'tahun',
        'nama_bulan',
        'total_tagihan_setoran',
        'total_setoran',
        'sisa_setoran',
        'keterangan',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Get Setoran Keuangan with optional filters.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSetoranWithFilters(array $filters = [])
    {
        $query = self::select(
            'id_setoran_keuangan',
            'tahun',
            'nama_bulan',
            'total_tagihan_setoran as total_bayar',
            'total_setoran',
            'sisa_setoran',
            'status',
            'created_at'
        )
            ->orderBy('created_at', 'DESC');

        if (!empty($filters['filter_tahun'])) {
            $query->where('tahun', $filters['filter_tahun']);
        }

        if (!empty($filters['filter_bulan'])) {
            $query->where('bulan', $filters['filter_bulan']);
        }

        if (!empty($filters['filter_status']) && $filters['filter_status'] != '') {
            $query->where('status', $filters['filter_status']);
        }

        return $query->get();
    }
}
