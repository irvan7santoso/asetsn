<?php

namespace Database\Seeders;

use App\Models\Asettlsn;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class dummyasetseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asetdata = [
            [
                'namabarang'=>'Kursi Chitose Meja',
                'tahun'=>'2012',
                'jumlah'=>'67',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'200000000',
                'lokasi'=>'Kelas Besar',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Mobil Xenia',
                'tahun'=>'2009',
                'jumlah'=>'22',
                'nomorinventaris'=>'',
                'nomorseri'=>'1343321',
                'harga'=>'110000000',
                'lokasi'=>'Garasi',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Meja Coklat',
                'tahun'=>'2022',
                'jumlah'=>'35',
                'nomorinventaris'=>'',
                'nomorseri'=>'41284778232',
                'harga'=>'1000000',
                'lokasi'=>'Gudang',
                'pemakai'=>'',
                'kondisi'=>'Sedang'
            ],
            [
                'namabarang'=>'AC Daikin',
                'tahun'=>'2024',
                'jumlah'=>'4',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'2500000',
                'lokasi'=>'Kantor',
                'pemakai'=>'',
                'kondisi'=>'Rusak'
            ],
            [
                'namabarang'=>'Proyektor LCD Maxell',
                'tahun'=>'2021',
                'jumlah'=>'5',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'1500000',
                'lokasi'=>'Kantor',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Rak Besi',
                'tahun'=>'2022',
                'jumlah'=>'8',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'1000000',
                'lokasi'=>'',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Kursi Lipat',
                'tahun'=>'20024',
                'jumlah'=>'12',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'125000',
                'lokasi'=>'',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Meja Makan',
                'tahun'=>'2003',
                'jumlah'=>'6',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'3000000',
                'lokasi'=>'',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Mobil Daihatsu Grandmax AB 1234 CD',
                'tahun'=>'2020',
                'jumlah'=>'1',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'12000000',
                'lokasi'=>'Garasi',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Mobil Phanter AB 4321 DC',
                'tahun'=>'2012',
                'jumlah'=>'1',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'12000000',
                'lokasi'=>'Garasi',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Iphone 20 Pro Max',
                'tahun'=>'2024',
                'jumlah'=>'6',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'1250000',
                'lokasi'=>'Aula',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ]
            
        ];

        foreach($asetdata as $key => $val){
            Asettlsn::create($val);
        }
    }
}
