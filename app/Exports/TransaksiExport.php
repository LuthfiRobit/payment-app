<?php

namespace App\Exports;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class TransaksiExport

implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $tahunAkademikId;
    protected $bulan;

    public function __construct($tahunAkademikId, $bulan)
    {
        $this->tahunAkademikId = $tahunAkademikId;
        $this->bulan = $bulan;
    }

    public function collection()
    {
        // Query the data based on tahun_akademik_id and month
        $transaksi = DB::table('transaksi')
            ->select(
                'transaksi.nomor_transaksi',
                'transaksi.jumlah_bayar',
                'transaksi.tanggal_bayar',
                'transaksi.status',
                'siswa.nama_siswa',
                'siswa.nis',
                'tahun_akademik.tahun',
                'tahun_akademik.semester'
            )
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'transaksi.siswa_id')
            ->leftJoin('tagihan', 'tagihan.id_tagihan', '=', 'transaksi.tagihan_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'tagihan.tahun_akademik_id')
            ->where('tahun_akademik.id_tahun_akademik', $this->tahunAkademikId)
            ->whereMonth('transaksi.tanggal_bayar', $this->bulan)
            ->orderBy('transaksi.created_at', 'DESC')
            ->get();

        // Format the data
        $transaksi = $transaksi->map(function ($item) {
            // Format Tahun Akademik
            $item->tahun_akademik = $item->tahun . ' - ' . $item->semester;

            // Format Tanggal as DD/MM/YYYY
            $item->tanggal_bayar = Carbon::parse($item->tanggal_bayar)->format('d/m/Y');

            // Return the columns in the correct order
            return [
                'nomor_transaksi' => $item->nomor_transaksi,  // A
                'tahun_akademik' => $item->tahun_akademik,    // B
                'nis' => $item->nis,                           // C
                'siswa' => $item->nama_siswa,                  // D
                'jumlah_bayar' => $item->jumlah_bayar,        // E
                'tanggal_bayar' => $item->tanggal_bayar,      // F
                'status' => $item->status                      // G
            ];
        });

        // Add the total row for jumlah_bayar
        $totalJumlahBayar = $transaksi->sum('jumlah_bayar');
        $transaksi->push([
            'nomor_transaksi' => 'Total',
            'tahun_akademik' => '',
            'nis' => '',
            'siswa' => '',
            'jumlah_bayar' => $totalJumlahBayar,
            'tanggal_bayar' => '',
            'status' => ''
        ]);

        return $transaksi;
    }

    public function headings(): array
    {
        return [
            'Nomor Transaksi',   // A
            'Tahun Akademik',    // B
            'Nis',               // C
            'Siswa',             // D
            'Total Transaksi',   // E
            'Tanggal',           // F
            'Status'             // G
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Bold the header (columns A to G)
                $event->sheet->getStyle('A1:G1')->getFont()->setBold(true);

                // Format the "Jumlah Bayar" (Total Transaksi) column (E)
                $event->sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0'); // Currency format

                // Format the "Tanggal" column (F) to date
                $event->sheet->getStyle('F')->getNumberFormat()->setFormatCode('DD/MM/YYYY');

                // Bold the total row in the "Total Transaksi" column (E)
                $rowCount = count(iterator_to_array($event->sheet->getRowIterator())); // Convert RowIterator to an array and count it
                $event->sheet->getStyle("E{$rowCount}")->getFont()->setBold(true); // Bold the total amount

                // Adjust column widths for better readability
                $event->sheet->getColumnDimension('A')->setWidth(20); // Nomor Transaksi
                $event->sheet->getColumnDimension('B')->setWidth(20); // Tahun Akademik
                $event->sheet->getColumnDimension('C')->setWidth(15); // Nis
                $event->sheet->getColumnDimension('D')->setWidth(30); // Siswa
                $event->sheet->getColumnDimension('E')->setWidth(20); // Total Transaksi
                $event->sheet->getColumnDimension('F')->setWidth(15); // Tanggal
                $event->sheet->getColumnDimension('G')->setWidth(15); // Status
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '#,##0',  // Format for jumlah_bayar (Total Transaksi)
            'E' => 'DD/MM/YYYY',  // Format for tanggal_bayar
        ];
    }
}
