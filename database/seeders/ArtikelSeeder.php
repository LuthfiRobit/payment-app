<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            $judul = $faker->sentence(6);
            $slug = Str::slug($judul);

            // Simulasi isi artikel (HTML format)
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

            Artikel::create([
                'user_id'   => '9db86ab8-2979-4d89-8df9-638ced29417f', // Ganti jika perlu
                'judul'     => $judul,
                'slug'      => $slug,
                'isi'       => $isi,
                'gambar'    => null, // dikosongkan sesuai permintaan
                'status'    => $i % 2 === 0 ? 'aktif' : 'tidak aktif',
                'dilihat'   => rand(0, 10),
            ]);
        }
    }
}
