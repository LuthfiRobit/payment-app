<?php

namespace Database\Seeders;

use App\Models\GuruKaryawan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuruKaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Data Guru
            [
                'id_guru_karyawan' => Str::uuid(),
                'nama' => 'Ustadz Ahmad Rifai',
                'jabatan' => 'Guru Tahfidz',
                'kategori' => 'guru',
                'foto' => null,
                'status' => 'aktif',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_guru_karyawan' => Str::uuid(),
                'nama' => 'Ustadzah Nur Aini',
                'jabatan' => 'Guru Bahasa Arab',
                'kategori' => 'guru',
                'foto' => null,
                'status' => 'aktif',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_guru_karyawan' => Str::uuid(),
                'nama' => 'Ustadz Hasan Al-Basri',
                'jabatan' => 'Guru Kelas VI',
                'kategori' => 'guru',
                'foto' => null,
                'status' => 'aktif',
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Data Karyawan
            [
                'id_guru_karyawan' => Str::uuid(),
                'nama' => 'H. Syamsul Huda',
                'jabatan' => 'Tata Usaha',
                'kategori' => 'karyawan',
                'foto' => null,
                'status' => 'aktif',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_guru_karyawan' => Str::uuid(),
                'nama' => 'Siti Rohmah',
                'jabatan' => 'Petugas Kebersihan',
                'kategori' => 'karyawan',
                'foto' => null,
                'status' => 'aktif',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('guru_karyawan')->insert($data);
    }
}
