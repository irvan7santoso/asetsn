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
         $user = Auth::user();

        if ($user->role == 'admin') {
            // Data untuk admin
            $asetRusak = Asettlsn::where('kondisi', 'Rusak')->count();
            $asetBaik = Asettlsn::where('kondisi', 'Baik')->count();
            $asetSedang = Asettlsn::where('kondisi', 'Sedang')->count();
            $asetdipinjam = Peminjaman::where('status', 'Dipinjam')->count();
            $asetbelumdikembalikan = Peminjaman::where('status', 'Melebihi batas waktu')->count();
            $recentPeminjaman = Peminjaman::latest()->take(5)->get();

            return view('welcome', compact('asetRusak', 'asetBaik', 'asetSedang', 'asetdipinjam', 'asetbelumdikembalikan', 'recentPeminjaman'));
        } elseif ($user->role == 'user') {
            // Data untuk user
            $jumlahPending = Peminjaman::where('id_user', $user->id)->where('status', 'Pending')->count();
            $jumlahDisetujui = Peminjaman::where('id_user', $user->id)->where('status', 'Disetujui')->count();
            $jumlahDipinjam = Peminjaman::where('id_user', $user->id)->where('status', 'Dipinjam')->count();
            $jumlahMelebihibataswaktu = Peminjaman::where('id_user', $user->id)->where('status', 'Melebihi batas waktu')->count();
            $recentPeminjaman = Peminjaman::where('id_user', $user->id)->latest()->take(5)->get();

            return view('welcome', compact('jumlahPending', 'jumlahDisetujui', 'jumlahDipinjam', 'jumlahMelebihibataswaktu', 'recentPeminjaman'));
        }

        // Jika role tidak dikenali, bisa redirect atau menampilkan error
        abort(403, 'Unauthorized action.');
    }
}