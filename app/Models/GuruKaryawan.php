<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GuruKaryawan extends Model
{
    use HasFactory;

    protected $table = 'guru_karyawan';
    protected $primaryKey = 'id_guru_karyawan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_guru_karyawan',
        'nama',
        'jabatan',
        'kategori',
        'foto',
        'status',
    ];

    // Set UUID otomatis saat create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id_guru_karyawan) {
                $model->id_guru_karyawan = (string) Str::uuid();
            }
        });
    }
}
