<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianSetoran extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rincian_setoran';
    protected $primaryKey = 'id_rincian_setoran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'setoran_keuangan_id',
        'iuran_id',
        'total_tagihan_setoran',
        'total_setoran',
        'sisa_setoran',
        'status',
        'created_at',
        'updated_at'
    ];

    public static function getByIdSetoran($id)
    {
        $query = self::select(
            'iuran.nama_iuran',
            'rincian_setoran.total_tagihan_setoran as total_tagihan',
            'rincian_setoran.total_setoran',
            'rincian_setoran.sisa_setoran',
            'rincian_setoran.status'
        )
            ->join('iuran', 'rincian_setoran.iuran_id', '=', 'iuran.id_iuran')
            ->where('rincian_setoran.setoran_keuangan_id', $id)
            ->get();

        return $query;
    }
}
