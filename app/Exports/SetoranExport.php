<?php

namespace App\Exports;

use App\Models\SetoranKeuangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SetoranExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $tahun;
    protected $bulan;

    public function __construct($tahun, $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function collection()
    {
        // Query untuk data setoran keuangan berdasarkan tahun dan bulan
        $setoranKeuangan = DB::table('setoran_keuangan')
            ->select(
                'setoran_keuangan.id_setoran_keuangan',
                'setoran_keuangan.total_tagihan_setoran',
                'setoran_keuangan.total_setoran',
                'setoran_keuangan.sisa_setoran',
                'setoran_keuangan.keterangan',
                'setoran_keuangan.status',
                'setoran_keuangan.bulan',
                'setoran_keuangan.tahun',
                'setoran_keuangan.created_at' // Ambil created_at untuk Tanggal Setor
            )
            ->where('setoran_keuangan.tahun', $this->tahun)
            ->where('setoran_keuangan.bulan', $this->bulan)
            ->orderBy('setoran_keuangan.created_at', 'DESC')
            ->get();

        // Format data
        $setoranKeuangan = $setoranKeuangan->map(function ($item) {
            // Format Tanggal Setor (created_at)
            $item->tanggal_setor = Carbon::parse($item->created_at)->format('d/m/Y');

            // Return the columns in the correct order
            return [
                'id_setoran_keuangan' => $item->id_setoran_keuangan,  // A
                'tahun' => $item->tahun,                               // B
                'bulan' => $item->bulan,                               // C (langsung angka bulan)
                'tanggal_setor' => $item->tanggal_setor,                // D
                'total_tagihan_setoran' => (float) $item->total_tagihan_setoran, // E (pastikan angka)
                'total_setoran' => (float) $item->total_setoran,        // F (pastikan angka)
                'sisa_setoran' => (float) $item->sisa_setoran,          // G (pastikan angka)
                'status' => $item->status,                              // H
                'keterangan' => $item->keterangan                       // I
            ];
        });

        // Add total row for total_tagihan_setoran, total_setoran, sisa_setoran
        $totalTagihan = $setoranKeuangan->sum('total_tagihan_setoran');
        $totalSetoran = $setoranKeuangan->sum('total_setoran');
        $totalSisaSetoran = $setoranKeuangan->sum('sisa_setoran');

        $setoranKeuangan->push([
            'id_setoran_keuangan' => 'Total',  // Label for total row
            'tahun' => '',
            'bulan' => '',
            'tanggal_setor' => '',
            'total_tagihan_setoran' => $totalTagihan,
            'total_setoran' => $totalSetoran,
            'sisa_setoran' => $totalSisaSetoran,
            'status' => '',
            'keterangan' => ''
        ]);

        return $setoranKeuangan;
    }

    public function headings(): array
    {
        return [
            'ID Setoran Keuangan',  // A
            'Tahun',                // B
            'Bulan',                // C
            'Tanggal Setor',        // D
            'Total Tagihan Setoran', // E
            'Total Setoran',        // F
            'Sisa Setoran',         // G
            'Status',               // H
            'Keterangan'            // I
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Bold the header (columns A to I)
                $event->sheet->getStyle('A1:I1')->getFont()->setBold(true);

                // Format the "Total Setoran", "Total Tagihan", and "Sisa Setoran" columns (E, F, G) to currency format
                $event->sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0'); // Currency format
                $event->sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0'); // Currency format
                $event->sheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0'); // Currency format

                // Format the "Tanggal Setor" column (D) to date format
                $event->sheet->getStyle('D')->getNumberFormat()->setFormatCode('DD/MM/YYYY'); // Date format

                // Bold the total row in the "Total Setoran" column (F) and other total columns
                $rowCount = count(iterator_to_array($event->sheet->getRowIterator())); // Convert RowIterator to an array and count it
                $event->sheet->getStyle("F{$rowCount}")->getFont()->setBold(true); // Bold the total amount for Setoran

                // Adjust column widths for better readability
                $event->sheet->getColumnDimension('A')->setWidth(25); // ID Setoran Keuangan
                $event->sheet->getColumnDimension('B')->setWidth(15); // Tahun
                $event->sheet->getColumnDimension('C')->setWidth(15); // Bulan
                $event->sheet->getColumnDimension('D')->setWidth(20); // Tanggal Setor
                $event->sheet->getColumnDimension('E')->setWidth(25); // Total Tagihan Setoran
                $event->sheet->getColumnDimension('F')->setWidth(25); // Total Setoran
                $event->sheet->getColumnDimension('G')->setWidth(25); // Sisa Setoran
                $event->sheet->getColumnDimension('H')->setWidth(15); // Status
                $event->sheet->getColumnDimension('I')->setWidth(30); // Keterangan
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => '#,##0',  // Format for total_tagihan_setoran
            'F' => '#,##0',  // Format for total_setoran
            'G' => '#,##0',  // Format for sisa_setoran
            'D' => 'DD/MM/YYYY',  // Format for tanggal_setor
        ];
    }
}
