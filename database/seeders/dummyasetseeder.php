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
        $asetdata = [];

        // Example data for locations, conditions, and pemakai
        $locations = ['Garasi', 'Kantor', 'Gudang', 'Kelas Besar', 'Aula'];
        $conditions = ['Baik', 'Sedang', 'Rusak'];
        $items = [
            'Mobil', 'Motor', 'Kursi', 'Meja','AC', 'Proyektor', 'Mouse', 'Laptop',
            'HP', 'Printer', 'Rol Kabel', 'Kipas angin', 'Kulkas', 'Lemari', 'Kasur', 'Komputer', 'Dispenser',
            'Mouse', 'Scanner', 'Voice Recorder', 'Papan Tulis', 'CCTV', 'Gedung'
        ];

        // Loop to generate 50 dummy data
        for ($i = 1; $i <= 50; $i++) {
            $asetdata[] = [
                'namabarang' => $items[array_rand($items)] . ' ' . rand(1000, 9999) . ' ' . chr(rand(65, 90)) . chr(rand(65, 90)), // Random license or asset code
                'tahun' => rand(1995, 2024),
                'jumlah' => rand(1, 10), // Random quantity
                'jumlah_tersedia' => rand(0, 10), // Random available quantity
                'nomorinventaris' => null,
                'nomorseri' => null,
                'harga' => rand(1000000, 50000000), // Random price
                'lokasi' => $locations[array_rand($locations)],
                'pemakai' => '', // Blank pemakai
                'kondisi' => $conditions[array_rand($conditions)], // Random condition
            ];
        }

        // Insert the generated data into the database
        foreach ($asetdata as $val) {
            Asettlsn::create($val);
        }
    }
}
