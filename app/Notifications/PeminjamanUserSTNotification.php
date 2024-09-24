<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeminjamanUserSTNotification extends Notification
{
    use Queueable;

    protected $peminjaman;
    protected $status;

    public function __construct($peminjaman, $status)
    {
        // Hanya kirim notifikasi untuk status 'Disetujui' atau 'Ditolak'
        if (!in_array($status, ['Disetujui', 'Ditolak'])) {
            return; // Jika status bukan 'Disetujui' atau 'Ditolak', keluar dari constructor
        }

        $this->peminjaman = $peminjaman;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database']; // Menyimpan notifikasi ke dalam database
    }

    public function toDatabase($notifiable)
    {
        $namaPeminjam = $this->peminjaman->nama_peminjam;
        $tglPeminjaman = $this->peminjaman->tgl_peminjaman;
        $tglKembali = $this->peminjaman->tgl_kembali;
        $peminjamanId = $this->peminjaman->id_peminjaman;

        if ($this->status === 'Disetujui') {
            $message = "Peminjaman oleh $namaPeminjam pada $tglPeminjaman s/d $tglKembali telah disetujui.";
        } elseif ($this->status === 'Ditolak') {
            $message = "Peminjaman oleh $namaPeminjam pada $tglPeminjaman s/d $tglKembali ditolak.";
        }

        return [
            'message' => $message,
            'peminjaman_id' => $peminjamanId,
            'status' => $this->status,
            'url' => route('peminjaman.userShow', ['id' => $peminjamanId]), // Sesuaikan URL dengan route
        ];
    }
}