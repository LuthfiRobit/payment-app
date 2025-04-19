<?php

namespace Database\Seeders;

use App\Models\Galeri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galeris = [
            [
                'tanggal' => '2024-01-10',
                'kegiatan' => 'Kegiatan Bakti Sosial',
                'keterangan' => 'Mengunjungi panti asuhan dan berbagi sembako',
                'foto' => 'https://picsum.photos/seed/galeri1/300/200',
                'status' => 'aktif',
            ],
            [

                'tanggal' => '2024-02-05',
                'kegiatan' => 'Lomba Kebersihan',
                'keterangan' => 'Lomba antar kelas untuk menjaga kebersihan sekolah',
                'foto' => 'https://picsum.photos/seed/galeri2/300/200',
                'status' => 'aktif',
            ],
            [

                'tanggal' => '2024-03-15',
                'kegiatan' => 'Pengajian Akbar',
                'keterangan' => 'Mengundang ustadz nasional untuk ceramah',
                'foto' => 'https://picsum.photos/seed/galeri3/300/200',
                'status' => 'tidak aktif',
            ],
            [

                'tanggal' => '2023-12-25',
                'kegiatan' => 'Kegiatan Outing Class',
                'keterangan' => 'Kunjungan edukatif ke museum dan taman kota',
                'foto' => 'https://picsum.photos/seed/galeri4/300/200',
                'status' => 'aktif',
            ],
            [

                'tanggal' => '2024-04-01',
                'kegiatan' => 'Pentas Seni',
                'keterangan' => 'Pertunjukan seni oleh siswa',
                'foto' => 'https://picsum.photos/seed/galeri5/300/200',
                'status' => 'aktif',
            ],
            [

                'tanggal' => '2023-10-18',
                'kegiatan' => 'Lomba Mewarnai',
                'keterangan' => null,
                'foto' => 'https://picsum.photos/seed/galeri6/300/200',
                'status' => 'tidak aktif',
            ],
            [

                'tanggal' => '2023-11-30',
                'kegiatan' => 'Donor Darah',
                'keterangan' => 'Kerja sama dengan PMI setempat',
                'foto' => 'https://picsum.photos/seed/galeri7/300/200',
                'status' => 'aktif',
            ],
            [

                'tanggal' => '2024-05-12',
                'kegiatan' => 'Kegiatan Ramadan',
                'keterangan' => 'Pesantren kilat selama bulan Ramadan',
                'foto' => 'https://picsum.photos/seed/galeri8/300/200',
                'status' => 'aktif',
            ],
            [

                'tanggal' => '2023-09-20',
                'kegiatan' => 'Lomba Pidato',
                'keterangan' => 'Peserta dari seluruh kelas',
                'foto' => 'https://picsum.photos/seed/galeri9/300/200',
                'status' => 'tidak aktif',
            ],
            [

                'tanggal' => '2024-06-05',
                'kegiatan' => 'Upacara Hari Pendidikan',
                'keterangan' => 'Peringatan hari pendidikan nasional',
                'foto' => 'https://picsum.photos/seed/galeri10/300/200',
                'status' => 'aktif',
            ],
        ];

        foreach ($galeris as $data) {
            Galeri::create($data);
        }
    }
}
