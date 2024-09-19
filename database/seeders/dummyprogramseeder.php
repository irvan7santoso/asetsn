<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class dummyprogramseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userdata = [
            [
                'nama_program'=>'Senam Sehat',
                'judul_kegiatan'=>'Senam Sehat Banget',
                'lokasi_kegiatan'=>'Lapangan Senam'
             ],
             [
                'nama_program'=>'Belajar Membaca',
                'judul_kegiatan'=>'Belajar Membaca Anak',
                'lokasi_kegiatan'=>'Balai Desa'
             ],
             [
                'nama_program'=>'Bakti Sosial',
                'judul_kegiatan'=>'Droping Air Bersih',
                'lokasi_kegiatan'=>'Padang Pasir'
             ],
             [
                'nama_program'=>'Lari Lari',
                'judul_kegiatan'=>'Lari Pagi',
                'lokasi_kegiatan'=>'Alun Alun'
             ]
            
        ];

        foreach($userdata as $key => $val){
            Program::create($val);
        }
    }
}
