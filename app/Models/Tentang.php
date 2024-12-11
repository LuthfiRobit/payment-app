<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tentang extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'tentang';
    protected $primaryKey = 'id_tentang';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'id_tentang',
        'deskripsi',
        'img',
        'status',
    ];

    // Gunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    // Ciptakan UUID otomatis ketika membuat data baru
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id_tentang = (string) Str::uuid();
        });
    }
}
