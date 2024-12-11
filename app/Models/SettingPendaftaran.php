<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SettingPendaftaran extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'setting_pendaftaran';
    protected $primaryKey = 'id_setting';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'id_setting',
        'tanggal_mulai',
        'tanggal_selesai',
        'biaya_pendaftaran',
        'status',
    ];

    // Gunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    // Ciptakan UUID otomatis ketika membuat data baru
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id_setting = (string) Str::uuid();
        });
    }
}
