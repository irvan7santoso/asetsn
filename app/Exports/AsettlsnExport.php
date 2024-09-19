<?php
namespace App\Exports;

use App\Models\Asettlsn;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class AsettlsnExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell
{
    private $rowNumber = 1; // Inisialisasi nomor urut

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
            'No',              // Mengubah ID menjadi No (Nomor Urut)
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
        // Ambil semua peminjaman terkait dengan aset ini yang berstatus dipinjam
        $peminjamans = $asettlsn->peminjamans()->withPivot('jumlah_dipinjam')->get();

        // Array untuk menyimpan nama peminjam dan jumlah aset yang dipinjam
        $pemakaiList = [];

        // Loop melalui setiap peminjaman yang terkait dengan aset ini
        foreach ($peminjamans as $peminjaman) {
            $pemakaiList[] = $peminjaman->nama_peminjam . ' (' . $peminjaman->pivot->jumlah_dipinjam . ')';
        }

        // Gabungkan semua nama peminjam dan jumlahnya menjadi satu string
        $pemakaiString = implode(', ', $pemakaiList);

        return [
            $this->rowNumber++,    // Menampilkan nomor urut dan increment
            $asettlsn->namabarang,
            $asettlsn->tahun,
            $asettlsn->jumlah,
            (string)$asettlsn->nomorinventaris,
            (string)$asettlsn->nomorseri,
            (float)$asettlsn->harga,
            $asettlsn->lokasi,
            $pemakaiString,        // Menampilkan informasi pemakai di kolom ini
            $asettlsn->kondisi,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menambahkan gambar dan header sesuai dengan penjelasan sebelumnya
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('assets/img/exportlogo.jpg')); // Ganti dengan path logo Anda
                $drawing->setHeight(110);
                $drawing->setCoordinates('C1');
                $drawing->setWorksheet($event->sheet->getDelegate());

                $headerText = "DAFTAR INVENTARIS ASET YAYASAN SATUNAMA YOGYAKARTA\n" .
                              "Jl. Sambisari 99 Duwet RT.07/RW.34, Sendangadi, Mlati, Sleman\n" .
                              "Yogyakarta";
                $event->sheet->setCellValue('A1', $headerText);
                $event->sheet->mergeCells('A1:J3');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1')->getFont()->setSize(14);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(20);
                $event->sheet->getDelegate()->getRowDimension('3')->setRowHeight(20);

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5); // Kolom No
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30); // Kolom Nama Barang
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15); // Kolom Tahun
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10); // Kolom Jumlah
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(25); // Kolom Nomor Inventaris
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(25); // Kolom Nomor Seri
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20); // Kolom Harga
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(30); // Kolom Lokasi
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(25); // Kolom Pemakai
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(15); // Kolom Kondisi

            // Menambahkan tanggal di bawah logo (misalnya di A4)
            $tanggalExport = now()->format('d-m-Y'); // Format tanggal dd-mm-yyyy
            $event->sheet->setCellValue('A4', 'Tanggal Export: ' . $tanggalExport); // Menampilkan tanggal export
            $event->sheet->getStyle('A4')->getFont()->setItalic(true); // Menjadikan teks miring
            $event->sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            // Menambahkan border untuk header kolom (baris 5)
            $event->sheet->getStyle('A5:J5')
                ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK)
                ->setColor(new Color(Color::COLOR_BLACK));

            // Menambahkan background warna hijau untuk header kolom
            $event->sheet->getStyle('A5:J5')
                ->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('90EE90'); // Warna hijau

            // **Menambahkan alignment tengah pada header kolom**
            $event->sheet->getStyle('A5:J5')
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            // Menghitung jumlah data secara dinamis
            $highestRow = $event->sheet->getHighestRow(); // Baris terakhir dengan data
            
            // Menerapkan border pada tabel data sesuai dengan jumlah data
            $event->sheet->getStyle('A5:J' . $highestRow)
                ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color(Color::COLOR_BLACK));
                $event->sheet->getStyle('G5:G100') // Sesuaikan range sel untuk harga
                ->getNumberFormat()
                ->setFormatCode('[$Rp-421]* #,##0.00_-;[$Rp-421]* (#,##0.00)_-;[$Rp-421]* "-"_-;@_-'); // Format accounting dalam Rupiah
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
        return 'A5'; // Memulai data dari baris ketiga setelah header dan gambar
    }
}
