<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 15; $i++) {
            $judul = $faker->sentence(6);
            $slug = Str::slug($judul);

            // Simulasi isi konten dari CKEditor (mengandung HTML)
            $isi = '
                <h2>' . $faker->sentence(5) . '</h2>
                <p>' . $faker->paragraph(3) . '</p>
                <p>' . $faker->paragraph(4) . '</p>
                <ul>
                    <li>' . $faker->sentence(6) . '</li>
                    <li>' . $faker->sentence(6) . '</li>
                    <li>' . $faker->sentence(6) . '</li>
                </ul>
                <p><strong>' . $faker->sentence(5) . '</strong></p>
            ';

            Berita::create([
                'user_id'   => 'c7ef0d62-f091-479f-9285-9e721ee7aa6e', // Ganti kalau ada user tertentu
                'judul'     => $judul,
                'slug'      => $slug,
                'isi'       => $isi,
                'gambar'    => "https://picsum.photos/seed/berita{$i}/500/250",
                'status'    => $i % 2 === 0 ? 'aktif' : 'tidak aktif',
                'dilihat'   => rand(0, 10),
            ]);
        }
    }
}
