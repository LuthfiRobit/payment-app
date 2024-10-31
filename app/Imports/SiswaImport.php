<?php

namespace App\Imports;

use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SiswaImport implements ToCollection, WithHeadingRow, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use Importable, SkipsFailures;

    protected $successfulRows = [];
    protected $failures = [];

    public function __construct()
    {
        HeadingRowFormatter::default('none'); // Set formatter ke 'none'
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $errors = [];

            // Validasi kolom
            if (empty($row['NIS'])) {
                $errors[] = 'NIS : kosong';
            }
            if (empty($row['NAMA'])) {
                $errors[] = 'NAMA : kosong';
            }
            if (empty($row['STATUS'])) {
                $errors[] = 'STATUS : kosong';
            }
            if (empty($row['JK'])) {
                $errors[] = 'JK : kosong';
            }
            if (empty($row['KELAS'])) {
                $errors[] = 'KELAS : kosong';
            }

            // Validasi nis unik
            if (Siswa::where('nis', $row['NIS'])->exists()) {
                $errors[] = 'NIS : sudah ada';
            }

            // Jika ada kesalahan, tambahkan ke kegagalan dan masukkan nomor baris
            if (!empty($errors)) {
                $this->failures[] = [
                    'row' => $row,
                    'row_number' => $index + 2,
                    'errors' => $errors
                ];
                continue;
            }

            // Jika lolos validasi, simpan data ke dalam database
            DB::beginTransaction();
            try {
                $tanggalLahir = isset($row['TANGGAL LAHIR']) ? Date::excelToDateTimeObject($row['TANGGAL LAHIR'])->format('Y-m-d') : null;

                $siswaData = [
                    'id_siswa' => Str::uuid(),
                    'nis' => $row['NIS'],
                    'nama_siswa' => $row['NAMA'],
                    'status' => $row['STATUS'],
                    'jenis_kelamin' => $row['JK'],
                    'tanggal_lahir' => $tanggalLahir,
                    'tempat_lahir' => $row['TEMPAT LAHIR'] ?? null,
                    'alamat' => $row['ALAMAT'] ?? null,
                    'nomor_telepon' => $row['NO TELEPON'] ?? null,
                    'email' => $row['EMAIL'] ?? null,
                    'kelas' => $row['KELAS'],
                ];

                Siswa::create($siswaData);
                DB::commit();

                // Simpan data yang berhasil
                $this->successfulRows[] = $siswaData;
            } catch (\Exception $e) {
                Log::error('Import Excel error: ' . $e->getMessage());
                DB::rollBack();
                $this->failures[] = [
                    'row' => $row,
                    'row_number' => $index + 2,
                    'errors' => ['Database error: ' . $e->getMessage()]
                ];
            }
        }
    }

    public function failures()
    {
        return $this->failures;
    }

    public function successfulRows()
    {
        return $this->successfulRows;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
