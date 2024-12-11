<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $kelas = ['1', '2', '3', '4', '5', '6'];
        $jenisKelamin = ['laki-laki', 'perempuan'];

        foreach ($kelas as $k) {
            for ($i = 1; $i <= 5; $i++) {
                Siswa::create([
                    'id_siswa' => Str::uuid(),
                    'user_id' => null,
                    'nis' => $k . $i,
                    'nama_siswa' => $faker->name($jenisKelamin[array_rand($jenisKelamin)]),
                    'status' => 'aktif',
                    'jenis_kelamin' => $jenisKelamin[array_rand($jenisKelamin)],
                    'tanggal_lahir' => $faker->date(),
                    'tempat_lahir' => $faker->city(),
                    'alamat' => $faker->address(),
                    'nomor_telepon' => $faker->phoneNumber(),
                    'email' => $faker->unique()->safeEmail(),
                    'kelas' => $k,
                ]);
            }
        }
    }
}
