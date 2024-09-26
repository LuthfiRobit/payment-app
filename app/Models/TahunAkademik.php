<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAkademik extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tahun_akademik';
    protected $primaryKey = 'id_tahun_akademik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tahun',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get all of the tagihan for the TahunAkademik
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }
}
