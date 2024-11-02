<?php

namespace Database\Seeders;

use App\Models\Asettlsn;
use Illuminate\Database\Seeder;

class DummyAsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data aset yang diinput secara manual
        $asetdata = [
            [
                'namabarang' => 'Laptop 1234 AB',
                'tahun' => 2020,
                'jumlah' => 5,
                'harga' => 10000000,
                'lokasi' => 'Kantor',
                'kondisi' => 'Baik',
            ],
            [
                'namabarang' => 'Printer 5678 CD',
                'jumlah' => 2,
                'harga' => 5000000,
                'lokasi' => 'Garasi',
                'kondisi' => 'Sedang',
            ],
            // Tambahkan data aset lainnya sesuai kebutuhan
        ];

        // Insert data aset ke dalam database
        foreach ($asetdata as $val) {
            Asettlsn::create($val);
        }
    }
}
