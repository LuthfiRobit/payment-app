<?php

namespace Database\Seeders;

use App\Models\AyahSiswaBaru;
use App\Models\IbuSiswaBaru;
use App\Models\KeluargaSiswaBaru;
use App\Models\SiswaBaru;
use App\Models\WaliSiswaBaru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SiswaBaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $tahunAkademikId = '179424ae-1738-4c3c-9adf-595f1eb79547'; // ID Tahun Akademik yang ditentukan
        $nomorRegistrasi = 20240002; // Format nomor registrasi dimulai dari 20240001

        // Generate 15 siswa baru
        for ($i = 0; $i < 15; $i++) {
            // Generate nomor registrasi untuk setiap siswa
            $nomorRegistrasiString = '2024' . str_pad($nomorRegistrasi, 4, '0', STR_PAD_LEFT);
            $nomorRegistrasi++; // Increment nomor registrasi

            // Create SiswaBaru
            $siswaBaru = SiswaBaru::create([
                'id_siswa_baru' => Str::uuid(),
                'tahun_akademik_id' => $tahunAkademikId, // Menggunakan ID Tahun Akademik yang sudah ditentukan
                'nik' => $faker->unique()->numerify('##########'),
                'no_registrasi' => $nomorRegistrasiString, // Menggunakan format tahun dan nomor urut
                'nama_lengkap_siswa' => $faker->name,
                'nama_panggilan' => $faker->firstName,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d'),
                'status' => $faker->randomElement(['diterima', 'ditolak', 'digenerate']),
                'jenis_kelamin' => $faker->randomElement(['laki-laki', 'perempuan']),
                'usia_saat_mendaftar' => $faker->numberBetween(6, 12),
                'jumlah_saudara' => $faker->numberBetween(1, 5),
                'anak_ke' => $faker->numberBetween(1, 5),
                'nomor_peci' => $faker->optional()->randomNumber(1),
                'nomor_hp_wa' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'jarak_dari_rumah_ke_sekolah' => $faker->numberBetween(1, 20),
                'perjalanan_ke_sekolah' => $faker->randomElement(['jalan_kaki', 'sepeda', 'motor', 'mobil', 'angkot', 'ojek', 'lainnya']),
                'sekolah_sebelum_mi' => $faker->word,
                'nama_ra_tk' => $faker->word,
                'alamat_ra_tk' => $faker->address,
                'imunisasi' => json_encode(['BCG', 'Polio', 'DPT']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create Ibu Siswa Baru
            IbuSiswaBaru::create([
                'id_ibu_siswa_baru' => Str::uuid(),
                'siswa_baru_id' => $siswaBaru->id_siswa_baru,
                'nama_ibu_kandung' => $faker->name,
                'status_ibu_kandung' => $faker->randomElement(['Hidup', 'Meninggal']),
                'nik_ibu' => $faker->unique()->numerify('##########'),
                'tempat_lahir_ibu' => $faker->city,
                'tanggal_lahir_ibu' => $faker->date('Y-m-d'),
                'pendidikan_terakhir_ibu' => $faker->randomElement(['sd', 'smp', 'sma', 'diploma', 'sarjana', 'pascaSarjana']),
                'pekerjaan_ibu' => $faker->randomElement(['ibuRumahTangga', 'guru', 'pegawaiNegeri', 'swasta', 'wiraswasta', 'lainnya']),
                'penghasilan_per_bulan_ibu' => $faker->numberBetween(1000000, 5000000),
                'alamat_ibu' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create Ayah Siswa Baru
            AyahSiswaBaru::create([
                'id_ayah_siswa_baru' => Str::uuid(),
                'siswa_baru_id' => $siswaBaru->id_siswa_baru,
                'nama_ayah_kandung' => $faker->name,
                'status_ayah_kandung' => $faker->randomElement(['Hidup', 'Meninggal']),
                'nik_ayah' => $faker->unique()->numerify('##########'),
                'tempat_lahir_ayah' => $faker->city,
                'tanggal_lahir_ayah' => $faker->date('Y-m-d'),
                'pendidikan_terakhir_ayah' => $faker->randomElement(['sd', 'smp', 'sma', 'diploma', 'sarjana', 'pascaSarjana']),
                'pekerjaan_ayah' => $faker->randomElement(['pegawaiNegeri', 'swasta', 'wiraswasta', 'buruh', 'lainnya']),
                'penghasilan_per_bulan_ayah' => $faker->numberBetween(2000000, 10000000),
                'alamat_ayah' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create Keluarga Siswa Baru
            KeluargaSiswaBaru::create([
                'id_keluarga_siswa_baru' => Str::uuid(),
                'siswa_baru_id' => $siswaBaru->id_siswa_baru,
                'nama_kepala_keluarga' => $faker->name,
                'nomor_kk' => $faker->unique()->numerify('##########'),
                'alamat_rumah' => $faker->address,
                'yang_membiayai_sekolah' => $faker->randomElement(['ayah', 'ibu', 'wali']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Optional: Create Wali Siswa Baru if random chance (50%)
            if ($faker->boolean(50)) {
                WaliSiswaBaru::create([
                    'id_wali_siswa_baru' => Str::uuid(),
                    'siswa_baru_id' => $siswaBaru->id_siswa_baru,
                    'nama_wali' => $faker->name,
                    'scan_kk_wali' => null,  // Ignored per requirements
                    'scan_kartu_pkh' => null,  // Ignored per requirements
                    'scan_kartu_kks' => null,  // Ignored per requirements
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
