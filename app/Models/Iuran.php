<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Iuran extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'iuran';
    protected $primaryKey = 'id_iuran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_iuran',
        'besar_iuran',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get all of the tagihanSiswa for the Iuran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihanSiswa(): HasMany
    {
        return $this->hasMany(TagihanSiswa::class, 'iuran_id', 'id_iuran');
    }
}
