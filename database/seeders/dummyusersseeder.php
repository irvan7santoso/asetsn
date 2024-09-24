<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class dummyusersseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userdata = [
            [
                'email'=>'irvan7santoso@gmail.com',
                'password'=>bcrypt('123456'),
                'role'=>'admin',
                'nama'=>'Admin PAK',
                'nomor_hp'=>'08612387122',
                'departemen'=>'PAK',
                'jabatan'=>'Anggota'
             ],
             [
                'email'=>'rehanmahardika07@gmail.com',
                'password'=>bcrypt('123456'),
                'role'=>'user',
                'nama'=>'Rehan Mahardika',
                'nomor_hp'=>'08633234442',
                'departemen'=>'HRD',
                'jabatan'=>'Anggota'
             ]
            
        ];

        foreach($userdata as $key => $val){
            User::create($val);
        }
    }
}
