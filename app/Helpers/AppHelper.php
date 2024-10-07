<?php

namespace App\Helpers;

use App\Models\TahunAkademik;

class AppHelper
{
    // Mengambil tahun akademik aktif
    public static function getActiveAcademicYear()
    {
        return TahunAkademik::where('status', 'aktif')->first();
    }

    // Mengambil role pengguna yang login
    public static function getUserRole()
    {
        // $user = Auth::user();
        // return $user ? $user->role : null; // Mengembalikan role pengguna jika ada
    }
}
