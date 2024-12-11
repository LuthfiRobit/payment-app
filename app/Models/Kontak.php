<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kontak extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'kontak';
    protected $primaryKey = 'id_kontak';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'id_kontak',
        'kontak_telepon',
        'kontak_email',
        'kontak_alamat',
        'status',
    ];

    // Gunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    // Ciptakan UUID otomatis ketika membuat data baru
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id_kontak = (string) Str::uuid();
        });
    }
}
