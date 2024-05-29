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
                'namabarang'=>'Mobil Pajero',
                'tahun'=>'2012',
                'jumlah'=>'12',
                'nomorinventaris'=>'',
                'nomorseri'=>'123123894',
                'harga'=>'200000000',
                'lokasi'=>'Garasi',
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
                'namabarang'=>'TV 100Inch',
                'tahun'=>'2024',
                'jumlah'=>'2',
                'nomorinventaris'=>'',
                'nomorseri'=>'9878323',
                'harga'=>'2500000',
                'lokasi'=>'Kantor',
                'pemakai'=>'',
                'kondisi'=>'Rusak'
            ],
            [
                'namabarang'=>'TV 10Inch',
                'tahun'=>'2021',
                'jumlah'=>'12',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'25000',
                'lokasi'=>'Kantor',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Gerobak',
                'tahun'=>'2022',
                'jumlah'=>'8',
                'nomorinventaris'=>'21312',
                'nomorseri'=>'412414',
                'harga'=>'100000',
                'lokasi'=>'',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Kursi Lipat',
                'tahun'=>'20024',
                'jumlah'=>'99',
                'nomorinventaris'=>'21312838',
                'nomorseri'=>'412849128',
                'harga'=>'2050000',
                'lokasi'=>'',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Meja Makan',
                'tahun'=>'2003',
                'jumlah'=>'9',
                'nomorinventaris'=>'1241298491',
                'nomorseri'=>'14192839',
                'harga'=>'3000000',
                'lokasi'=>'',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Mobil Kodok',
                'tahun'=>'2007',
                'jumlah'=>'9',
                'nomorinventaris'=>'4124123',
                'nomorseri'=>'',
                'harga'=>'12000000',
                'lokasi'=>'Garasi',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Mobil Amfibi',
                'tahun'=>'2012',
                'jumlah'=>'20',
                'nomorinventaris'=>'',
                'nomorseri'=>'',
                'harga'=>'12000000',
                'lokasi'=>'Garasi',
                'pemakai'=>'',
                'kondisi'=>'Baik'
            ],
            [
                'namabarang'=>'Iphone 20 Pro Maximal Minimal',
                'tahun'=>'2023',
                'jumlah'=>'5',
                'nomorinventaris'=>'',
                'nomorseri'=>'987436358',
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
