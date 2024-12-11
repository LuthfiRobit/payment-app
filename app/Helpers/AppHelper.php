<?php

namespace App\Helpers;

use App\Models\Kontak;
use App\Models\SettingPendaftaran;
use App\Models\TahunAkademik;
use App\Models\Tentang;

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

    // Mengambil kontak aktif
    public static function getKontak()
    {
        return Kontak::where('status', 'aktif')->first();
    }

    // Mengambil tentang aktif
    public static function getTentang()
    {
        return Tentang::where('status', 'aktif')->first();
    }

    // Mengambil setting pendaftaran aktif
    public static function getSettingPendaftaran()
    {
        return SettingPendaftaran::where('status', 'aktif')->first();
    }
}
