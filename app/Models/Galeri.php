<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_galeri',
        'tanggal',
        'kegiatan',
        'keterangan',
        'foto',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_galeri = (string) Str::uuid();
        });
    }
}
