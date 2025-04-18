<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prestasis = [
            [
                'tanggal' => '2024-01-15',
                'nama_prestasi' => 'Lomba Hafalan Juz Amma',
                'keterangan' => 'Juara 1 tingkat Kabupaten',
                'foto_prestasi' => 'https://picsum.photos/seed/prestasi1/300/200',
                'status' => 'aktif',
            ],
            [
                'tanggal' => '2024-02-20',
                'nama_prestasi' => 'Lomba Cerdas Cermat Agama',
                'keterangan' => 'Juara 2 tingkat Kecamatan',
                'foto_prestasi' => 'https://picsum.photos/seed/prestasi2/300/200',
                'status' => 'aktif',
            ],
            [
                'tanggal' => '2024-03-05',
                'nama_prestasi' => 'Lomba Kaligrafi',
                'keterangan' => 'Juara Harapan 1 tingkat Kota',
                'foto_prestasi' => 'https://picsum.photos/seed/prestasi3/300/200',
                'status' => 'tidak aktif',
            ],
            [
                'tanggal' => '2023-11-10',
                'nama_prestasi' => 'Festival Anak Sholeh',
                'keterangan' => null,
                'foto_prestasi' => 'https://picsum.photos/seed/prestasi4/300/200',
                'status' => 'aktif',
            ],
            [
                'tanggal' => '2024-04-01',
                'nama_prestasi' => 'Lomba Pidato Islami',
                'keterangan' => 'Peserta terbaik',
                'foto_prestasi' => 'https://picsum.photos/seed/prestasi5/300/200',
                'status' => 'aktif',
            ],
            [
                'tanggal' => '2023-09-23',
                'nama_prestasi' => 'Lomba Adzan',
                'keterangan' => 'Juara 3 tingkat RW',
                'foto_prestasi' => 'https://picsum.photos/seed/prestasi6/300/200',
                'status' => 'tidak aktif',
            ],
            [
                'tanggal' => '2024-05-10',
                'nama_prestasi' => 'Lomba Nasyid',
                'keterangan' => 'Penampilan terbaik',
                'foto_prestasi' => 'https://picsum.photos/seed/prestasi7/300/200',
                'status' => 'aktif',
            ],
        ];

        foreach ($prestasis as $data) {
            Prestasi::create($data);
        }
    }
}
