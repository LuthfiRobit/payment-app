<?php

namespace App\Exports;

use App\Models\SiswaBaru;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaBaruExport implements FromCollection, WithHeadings
{
    protected $selectedIds;
    protected $includeIbu;
    protected $includeAyah;
    protected $includeWali;
    protected $includeKeluarga;

    // Constructor menerima parameter tambahan untuk data yang akan diekspor
    public function __construct(array $selectedIds, $includeIbu, $includeAyah, $includeWali, $includeKeluarga)
    {
        $this->selectedIds = $selectedIds;
        $this->includeIbu = $includeIbu;
        $this->includeAyah = $includeAyah;
        $this->includeWali = $includeWali;
        $this->includeKeluarga = $includeKeluarga;
    }

    public function collection()
    {
        // Ambil data siswa beserta relasi terkait, kecuali kolom file
        $query = SiswaBaru::whereIn('id_siswa_baru', $this->selectedIds)
            ->with([
                'tahunAkademik',
                'ibu',
                'ayah',
                'wali',
                'keluarga'
            ])
            ->get();

        // Mengambil semua kolom kecuali kolom yang berhubungan dengan file
        return $query->map(function ($siswa) {
            // Ambil data siswa baru
            $data = [
                // Tahun Akademik: format tahun + semester
                'tahun_akademik' => $siswa->tahunAkademik ? "{$siswa->tahunAkademik->tahun}-{$siswa->tahunAkademik->semester}" : null,
                // Data Siswa Baru
                'nama_siswa' => $siswa->nama_lengkap_siswa,
                'nik_siswa' => (string)$siswa->nik,
                'usia' => Carbon::parse($siswa->tanggal_lahir)->age,
                'nama_panggilan' => $siswa->nama_panggilan,
                'tempat_lahir' => $siswa->tempat_lahir,
                'tanggal_lahir' => Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y'),
                'jenis_kelamin' => $siswa->jenis_kelamin,
                'email' => $siswa->email,
                'nomor_hp_wa' => $siswa->nomor_hp_wa,
                'jumlah_saudara' => $siswa->jumlah_saudara,
                'anak_ke' => $siswa->anak_ke,
                'nomor_peci' => $siswa->nomor_peci,
                'jarak_dari_rumah_ke_sekolah' => $siswa->jarak_dari_rumah_ke_sekolah,
                'perjalanan_ke_sekolah' => $siswa->perjalanan_ke_sekolah,
                'sekolah_sebelum_mi' => $siswa->sekolah_sebelum_mi,
                'nama_ra_tk' => $siswa->nama_ra_tk,
                'alamat_ra_tk' => $siswa->alamat_ra_tk,
            ];

            // Data Ibu
            if ($this->includeIbu) {
                $data['ibu_nama'] = $siswa->ibu ? $siswa->ibu->nama_ibu_kandung : null;
                $data['ibu_nik'] = $siswa->ibu ? $siswa->ibu->nik_ibu : null;
                $data['ibu_status'] = $siswa->ibu ? $siswa->ibu->status_ibu_kandung : null;
                $data['ibu_tempat_lahir'] = $siswa->ibu ? $siswa->ibu->tempat_lahir_ibu : null;
                $data['ibu_tanggal_lahir'] = $siswa->ibu ? Carbon::parse($siswa->ibu->tanggal_lahir_ibu)->format('d/m/Y') : null;
                $data['ibu_pendidikan'] = $siswa->ibu ? $siswa->ibu->pendidikan_terakhir_ibu : null;
                $data['ibu_pekerjaan'] = $siswa->ibu ? $siswa->ibu->pekerjaan_ibu : null;
                $data['ibu_penghasilan'] = $siswa->ibu ? $siswa->ibu->penghasilan_per_bulan_ibu : null;
                $data['ibu_alamat'] = $siswa->ibu ? $siswa->ibu->alamat_ibu : null;
            }

            // Data Ayah
            if ($this->includeAyah) {
                $data['ayah_nama'] = $siswa->ayah ? $siswa->ayah->nama_ayah_kandung : null;
                $data['ayah_nik'] = $siswa->ayah ? $siswa->ayah->nik_ayah : null;
                $data['ayah_status'] = $siswa->ayah ? $siswa->ayah->status_ayah_kandung : null;
                $data['ayah_tempat_lahir'] = $siswa->ayah ? $siswa->ayah->tempat_lahir_ayah : null;
                $data['ayah_tanggal_lahir'] = $siswa->ayah ? Carbon::parse($siswa->ayah->tanggal_lahir_ayah)->format('d/m/Y') : null;
                $data['ayah_pendidikan'] = $siswa->ayah ? $siswa->ayah->pendidikan_terakhir_ayah : null;
                $data['ayah_pekerjaan'] = $siswa->ayah ? $siswa->ayah->pekerjaan_ayah : null;
                $data['ayah_penghasilan'] = $siswa->ayah ? $siswa->ayah->penghasilan_per_bulan_ayah : null;
                $data['ayah_alamat'] = $siswa->ayah ? $siswa->ayah->alamat_ayah : null;
            }

            // Data Wali
            if ($this->includeWali) {
                $data['wali_nama'] = $siswa->wali ? $siswa->wali->nama_wali : null;
                // $data['wali_scan_kk'] = $siswa->wali ? $siswa->wali->scan_kk_wali : null;
                // $data['wali_scan_kartu_pkh'] = $siswa->wali ? $siswa->wali->scan_kartu_pkh : null;
                // $data['wali_scan_kartu_kks'] = $siswa->wali ? $siswa->wali->scan_kartu_kks : null;
            }

            // Data Keluarga
            if ($this->includeKeluarga) {
                $data['keluarga_nama_kepala'] = $siswa->keluarga ? $siswa->keluarga->nama_kepala_keluarga : null;
                $data['keluarga_nomor_kk'] = $siswa->keluarga ? $siswa->keluarga->nomor_kk : null;
                $data['keluarga_alamat'] = $siswa->keluarga ? $siswa->keluarga->alamat_rumah : null;
                $data['keluarga_pemberi_dana'] = $siswa->keluarga ? $siswa->keluarga->yang_membiayai_sekolah : null;
            }

            return $data;
        });
    }

    public function headings(): array
    {
        $headings = [
            'Tahun Akademik',
            'Nama Siswa',
            'NIK',
            'Usia',
            'Nama Panggilan',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Email',
            'Nomor HP/WA',
            'Jumlah Saudara',
            'Anak Ke',
            'Nomor Peci',
            'Jarak Ke Sekolah',
            'Perjalanan Ke Sekolah',
            'Sekolah Sebelumnya',
            'Nama RA/TK',
            'Alamat RA/TK'
        ];

        if ($this->includeIbu) {
            $headings = array_merge($headings, ['Nama Ibu', 'NIK Ibu', 'Status Ibu', 'Tempat Lahir Ibu', 'Tanggal Lahir Ibu', 'Pendidikan Ibu', 'Pekerjaan Ibu', 'Penghasilan Ibu', 'Alamat Ibu']);
        }

        if ($this->includeAyah) {
            $headings = array_merge($headings, ['Nama Ayah', 'NIK Ayah', 'Status Ayah', 'Tempat Lahir Ayah', 'Tanggal Lahir Ayah', 'Pendidikan Ayah', 'Pekerjaan Ayah', 'Penghasilan Ayah', 'Alamat Ayah']);
        }

        if ($this->includeWali) {
            $headings = array_merge($headings, ['Nama Wali']);
            // $headings = array_merge($headings, ['Nama Wali', 'Scan KK Wali', 'Scan Kartu PKH Wali', 'Scan Kartu KKS Wali']);
        }

        if ($this->includeKeluarga) {
            $headings = array_merge($headings, ['Nama Kepala Keluarga', 'Nomor KK', 'Alamat Keluarga', 'Pemberi Dana']);
        }

        return $headings;
    }
}
