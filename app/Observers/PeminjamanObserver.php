<?php

namespace App\Observers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Notifications\PeminjamanMelebihiBatasWaktu;
use App\Notifications\PeminjamanSelesai;
use App\Notifications\PeminjamanOverdue;
use Carbon\Carbon;

class PeminjamanObserver
{
    public function updated(Peminjaman $peminjaman)
    {
        // Jika status menjadi "selesai", kirim notifikasi
        if ($peminjaman->status == 'Selesai') {
            $admin = User::where('role', 'admin')->get();  // Dapatkan semua admin

            // Kirim notifikasi ke admin
            foreach ($admin as $adm) {
                $adm->notify(new PeminjamanSelesai($peminjaman, true));
            }

            // Kirim notifikasi ke peminjam
            $peminjaman->user->notify(new PeminjamanSelesai($peminjaman));
        }

        // Cek apakah peminjaman melewati batas waktu
        $today = Carbon::now();
        if ($peminjaman->status != 'Selesai' && $peminjaman->tgl_kembali < $today) {
            $admin = User::where('role', 'admin')->get();

            // Kirim notifikasi overdue ke admin
            foreach ($admin as $adm) {
                $adm->notify(new PeminjamanMelebihiBatasWaktu($peminjaman, true));
            }

            // Kirim notifikasi overdue ke peminjam
            $peminjaman->user->notify(new PeminjamanMelebihiBatasWaktu($peminjaman));
        }
    }
}
