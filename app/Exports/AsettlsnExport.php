<?php
namespace App\Exports;

use App\Models\Asettlsn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AsettlsnExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Asettlsn::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Tahun',
            'Jumlah',
            'Nomor Inventaris',
            'Nomor Seri',
            'Harga',
            'Lokasi',
            'Pemakai',
            'Kondisi',
        ];
    }

    /**
     * @param mixed $asettlsn
     * 
     * @return array
     */
    public function map($asettlsn): array
    {
        return [
            $asettlsn->id,
            $asettlsn->nama_barang,
            $asettlsn->tahun,
            $asettlsn->jumlah,
            (string)$asettlsn->nomor_inventaris,
            (string)$asettlsn->nomor_seri,
            (float)$asettlsn->harga,
            $asettlsn->lokasi,
            $asettlsn->pemakai,
            $asettlsn->kondisi,
        ];
    }
}
