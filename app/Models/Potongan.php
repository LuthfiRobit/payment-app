<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Potongan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'potongan';
    protected $primaryKey = 'id_potongan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_potongan',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */

    /**
     * Get all of the potonganSiswa for the Potongan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function potonganSiswa(): HasMany
    {
        return $this->hasMany(PotonganSiswa::class, 'potongan_id', 'id_potongan');
    }
}
