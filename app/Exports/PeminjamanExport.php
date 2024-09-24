<?php

namespace App\Exports;

use App\Exports\PeminjamanDataExport;
use App\Exports\PeminjamanSummaryExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PeminjamanExport implements WithMultipleSheets
{
    /**
     * Export ke beberapa sheet
     */
    public function sheets(): array
    {
        return [
            'Data Peminjaman' => new PeminjamanDataExport(),
            'Rangkuman Aset Paling Sering Dipinjam' => new PeminjamanSummaryExport(),
        ];
    }
}
