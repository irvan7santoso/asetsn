<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell
{
    /**
     * Ambil data yang akan diexport
     */
    public function collection()
    {
        return Peminjaman::with('asettlsns')->get();
    }

    /**
     * Tentukan header kolom untuk Excel
     */
    public function headings(): array
    {
        return [
            'Nama Peminjam',
            'Aset yang Dipinjam',
            'Tanggal Peminjaman',
            'Tanggal Pengembalian',
            'Alasan Peminjaman',
            'Status'
        ];
    }

    /**
     * Mapping data ke dalam bentuk yang bisa diexport
     */
    public function map($peminjaman): array
    {
        $asetDetails = $peminjaman->asettlsns->map(function($aset) {
            return $aset->namabarang . '(Jmlh:' . $aset->pivot->jumlah_dipinjam . ')';
        })->toArray();
        
        $asetsString = implode(', ', $asetDetails);

        return [
            $peminjaman->nama_peminjam,
            $asetsString,
            \Carbon\Carbon::parse($peminjaman->tgl_peminjaman)->format('d-m-Y'),
            \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d-m-Y'),
            $peminjaman->program,
            $peminjaman->status,
        ];
    }

    /**
     * Register event untuk header, logo, tanggal export, dan formatting lainnya
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menambahkan logo
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('assets/img/exportlogo.jpg')); // Ganti dengan path logo Anda
                $drawing->setHeight(110);
                $drawing->setCoordinates('A1');
                $drawing->setWorksheet($event->sheet->getDelegate());

                // Header di atas tabel
                $headerText = "DAFTAR PEMINJAMAN ASET YAYASAN SATUNAMA YOGYAKARTA\n" .
                              "Jl. Sambisari 99 Duwet RT.07/RW.34, Sendangadi, Mlati, Sleman\n" .
                              "Yogyakarta";
                $event->sheet->setCellValue('A1', $headerText);
                $event->sheet->mergeCells('A1:F3');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1')->getFont()->setSize(14);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);

                // Ukuran row dan kolom
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(20);
                $event->sheet->getDelegate()->getRowDimension('3')->setRowHeight(20);
                
                // Tanggal Export
                $tanggalExport = now()->format('d-m-Y');
                $event->sheet->setCellValue('A4', 'Tanggal Export: ' . $tanggalExport);
                $event->sheet->getStyle('A4')->getFont()->setItalic(true);
                $event->sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Mengatur lebar kolom
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(25); // Kolom Nama Peminjam
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(70); // Kolom Aset yang Dipinjam
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20); // Kolom Tanggal Peminjaman
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20); // Kolom Tanggal Pengembalian
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(50); // Kolom Alasan Peminjaman
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20); // Kolom Status

                // Border untuk header tabel
                $event->sheet->getStyle('A5:F5')
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK)
                    ->setColor(new Color(Color::COLOR_BLACK));

                // Background warna hijau pada header
                $event->sheet->getStyle('A5:F5')
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('90EE90'); // Warna hijau

                // Alignment header tabel
                $event->sheet->getStyle('A5:F5')
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Border untuk data
                $highestRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A5:F' . $highestRow)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color(Color::COLOR_BLACK));
            },
        ];
    }

    /**
     * Start cell untuk heading data.
     * 
     * @return string
     */
    public function startCell(): string
    {
        return 'A5'; // Memulai data dari baris kelima setelah header dan gambar
    }
}
