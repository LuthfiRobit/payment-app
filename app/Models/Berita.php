<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_berita',
        'user_id',
        'judul',
        'slug',
        'isi',
        'gambar',
        'status',
        'dilihat',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_berita = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
