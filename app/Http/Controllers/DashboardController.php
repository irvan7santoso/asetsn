<?php

namespace App\Http\Controllers;

use App\Models\Asettlsn;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil 3 peminjaman terakhir dari database
        $recentPeminjaman = Peminjaman::orderBy('created_at', 'desc')->take(5)->get();
        
        // Mengambil data jumlah aset dipinjam
        $asetdipinjam = Peminjaman::where('status', 'Dipinjam')->count();

        // Mengambil data jumlah aset belum dikembalikan
        $asetbelumdikembalikan = Peminjaman::where('status', 'Melebihi batas waktu')->count();

        // Mengambil data kondisi aset dari database
        $asetBaik = Asettlsn::where('kondisi', 'Baik')->count();
        $asetRusak = Asettlsn::where('kondisi', 'Rusak')->count();
        $asetSedang = Asettlsn::where('kondisi', 'Sedang')->count();
        
        // Mengirim data ke view
        return view('welcome', compact('recentPeminjaman','asetBaik','asetRusak','asetSedang','asetdipinjam','asetbelumdikembalikan'));
    }
}