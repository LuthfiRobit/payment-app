<?php

namespace App\Http\Controllers\Registrasi;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\SiswaBaru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegistrasiGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $siswaIds = $request->input('siswa_ids');

        // Validasi input siswa_ids
        if ($this->isInvalidSiswaIds($siswaIds)) {
            return $this->errorResponse('Tidak ada siswa yang dipilih untuk generate.', 400);
        }

        // Ambil data siswa baru yang dipilih
        $siswaBaruData = $this->getSiswaBaruData($siswaIds);
        if ($siswaBaruData->isEmpty()) {
            return $this->errorResponse('Tidak ada siswa baru yang ditemukan dengan ID yang dipilih.', 404);
        }

        // Pastikan bahwa ada siswa dengan status 'diterima'
        $diterimaSiswa = $siswaBaruData->filter(function ($siswa) {
            return $siswa->status === 'diterima';
        });

        // Jika tidak ada siswa yang diterima, kembalikan respons error
        if ($diterimaSiswa->isEmpty()) {
            return $this->errorResponse('Tidak ada siswa baru yang diterima untuk diproses.', 400);
        }

        // Mulai transaksi untuk memastikan data konsisten
        DB::beginTransaction();

        try {
            // Ambil NIS yang sudah ada untuk tahun yang sama
            $existingNis = $this->getExistingNis();

            // Update kelas siswa yang ada
            $this->updateKelasSiswaYangAda();

            // Generate siswa baru
            $newSiswa = $this->generateSiswaBaru($siswaBaruData, $existingNis);

            // Batch insert siswa baru
            Siswa::insert($newSiswa);

            // Update status siswaBaru menjadi 'digenerate'
            $this->updateStatusSiswaBaru($siswaIds);

            // Commit transaksi jika semua langkah berhasil
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Siswa berhasil digenerate!']);
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();
            Log::error('Error generating siswa: ' . $e->getMessage());
            return $this->errorResponse('Terjadi kesalahan saat menggenerate siswa. Silakan coba lagi.', 500);
        }
    }

    /**
     * Memeriksa apakah siswa_ids tidak valid.
     */
    private function isInvalidSiswaIds($siswaIds)
    {
        return empty($siswaIds);
    }

    /**
     * Mengambil data siswa baru berdasarkan siswa_ids yang diberikan.
     */
    private function getSiswaBaruData($siswaIds)
    {
        try {
            return SiswaBaru::whereIn('id_siswa_baru', $siswaIds)->get();
        } catch (\Exception $e) {
            Log::error('Error fetching siswa baru: ' . $e->getMessage());
            throw new \Exception('Terjadi kesalahan saat mengambil data siswa baru.');
        }
    }

    /**
     * Menanggapi dengan format error JSON.
     */
    private function errorResponse($message, $statusCode)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }

    /**
     * Mengambil semua NIS yang ada untuk tahun ini.
     */
    private function getExistingNis()
    {
        $tahun = date('Y');
        return Siswa::where('nis', 'like', $tahun . '%')
            ->pluck('nis')
            ->toArray();
    }

    /**
     * Menangani proses pembuatan siswa baru.
     */
    private function generateSiswaBaru($siswaBaruData, &$existingNis)
    {
        $newSiswa = [];

        foreach ($siswaBaruData as $siswa) {
            if ($siswa->status !== 'diterima') {
                continue; // Skip siswa dengan status selain diterima
            }

            // Gunakan no_registrasi sebagai NIS
            $newNis = $siswa->no_registrasi;

            // Pastikan tidak ada duplikasi NIS
            $newNis = $this->generateUniqueNisFromNoRegistrasi($newNis, $existingNis);

            // Setelah mendapatkan NIS yang unik, tambahkan data siswa baru ke array
            $newSiswa[] = $this->prepareSiswaData($siswa, $newNis);

            // Tambahkan NIS yang baru ke array existingNis untuk referensi di masa depan
            $existingNis[] = $newNis;
        }

        return $newSiswa;
    }

    /**
     * Membuat NIS unik dari no_registrasi dengan memastikan tidak ada duplikasi.
     */
    private function generateUniqueNisFromNoRegistrasi($noRegistrasi, &$existingNis)
    {
        // Periksa apakah no_registrasi sudah ada di database
        $existingSiswa = Siswa::where('nis', $noRegistrasi)->first();

        // Jika NIS sudah ada, buat NIS baru dengan menambahkan suffix
        if ($existingSiswa || in_array($noRegistrasi, $existingNis)) {
            $counter = 1;
            $newNis = $noRegistrasi . $counter;

            // Pastikan NIS baru tidak duplikat
            while (Siswa::where('nis', $newNis)->exists() || in_array($newNis, $existingNis)) {
                $counter++;
                $newNis = $noRegistrasi . $counter;
            }

            return $newNis;
        }

        // Jika tidak ada duplikasi, gunakan no_registrasi yang ada
        return $noRegistrasi;
    }

    /**
     * Mempersiapkan data untuk siswa baru.
     */
    private function prepareSiswaData($siswa, $newNis)
    {
        return [
            'id_siswa' => Str::uuid(),
            'nis' => $newNis,
            'nama_siswa' => $siswa->nama_lengkap_siswa,
            'jenis_kelamin' => $siswa->jenis_kelamin,
            'tanggal_lahir' => $siswa->tanggal_lahir,
            'tempat_lahir' => $siswa->tempat_lahir,
            'alamat' => '', // Alamat kosong
            'nomor_telepon' => $siswa->nomor_hp_wa,
            'email' => $siswa->email,
            'status' => 'aktif',
            'kelas' => '1', // Siswa baru selalu kelas 1
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Mengupdate status siswaBaru menjadi 'digenerate' agar tidak diproses lagi.
     */
    private function updateStatusSiswaBaru($siswaIds)
    {
        SiswaBaru::whereIn('id_siswa_baru', $siswaIds)
            ->where('status', 'diterima')
            ->update(['status' => 'digenerate']);
    }

    /**
     * Memperbarui kelas siswa yang sudah ada.
     */
    private function updateKelasSiswaYangAda()
    {
        $siswaList = Siswa::all();

        foreach ($siswaList as $siswa) {
            $this->updateKelasSiswa($siswa);
        }
    }

    /**
     * Memperbarui kelas individu siswa.
     */
    private function updateKelasSiswa($siswa)
    {
        // Pastikan siswa tidak memiliki kelas '0' atau status 'lulus'
        if ($siswa->kelas === '0' || $siswa->status === 'lulus') {
            return;  // Jangan ubah kelas atau status jika sudah '0' atau 'lulus'
        }

        // Update kelas untuk siswa di kelas 1-5
        if (in_array($siswa->kelas, ['1', '2', '3', '4', '5'])) {
            $nextKelas = (string) ((int) $siswa->kelas + 1);  // Naikkan kelas
            $siswa->kelas = $nextKelas;
            $siswa->save();
        }

        // Update kelas untuk siswa di kelas 6
        if ($siswa->kelas === '6') {
            $siswa->kelas = '0';  // Kelas 6 jadi kelas 0 (lulus)
            $siswa->status = 'lulus';  // Status jadi lulus
            $siswa->save();
        }
    }
}
