<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths; // Import interface
use Illuminate\Support\Facades\DB;

class PeminjamanSummaryExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths // Tambahkan interface WithColumnWidths
{
    /**
     * Ambil data aset yang paling sering dipinjam
     */
    public function collection()
    {
        // Ambil data aset yang paling sering dipinjam menggunakan agregasi
        return DB::table('item_peminjaman')
            ->join('asettlsn', 'item_peminjaman.id_aset', '=', 'asettlsn.id')
            ->select('asettlsn.namabarang', DB::raw('SUM(item_peminjaman.jumlah_dipinjam) as total_dipinjam'))
            ->groupBy('asettlsn.namabarang')
            ->orderByDesc('total_dipinjam')
            ->get();
    }

    /**
     * Tentukan header kolom untuk Excel
     */
    public function headings(): array
    {
        return [
            'Nama Aset',
            'Total Dipinjam'
        ];
    }

    /**
     * Mapping data ke dalam bentuk yang bisa diexport
     */
    public function map($row): array
    {
        return [
            $row->namabarang,
            $row->total_dipinjam
        ];
    }

    /**
     * Tentukan lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 50, // Lebar untuk kolom 'Nama Aset'
            'B' => 25, // Lebar untuk kolom 'Total Dipinjam'
        ];
    }
}
