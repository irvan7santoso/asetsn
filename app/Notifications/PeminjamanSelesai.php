<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeminjamanSelesai extends Notification
{
    use Queueable;

    protected $peminjaman;
    protected $isAdmin;

    public function __construct($peminjaman, $isAdmin = false)
    {
        $this->peminjaman = $peminjaman;
        $this->isAdmin = $isAdmin;
    }

    public function via($notifiable)
    {
        return ['database']; // Menambahkan channel 'database' untuk menyimpan notifikasi ke database
    }

    public function toDatabase($notifiable)
    {
        // Membuat URL yang mengarah ke rute 'approve.show' dengan ID peminjaman
        $url = route('approve.show', ['id' => $this->peminjaman->id_peminjaman]);

        if ($this->isAdmin) {
            return [
                'message' => 'Peminjaman oleh ' . $this->peminjaman->nama_peminjam . ' telah selesai.',
                'peminjaman_id' => $this->peminjaman->id_peminjaman,
                'nama_peminjam' => $this->peminjaman->nama_peminjam,
                'program' => $this->peminjaman->program,
                'type' => 'selesai',
                'url' => $url, // Menambahkan URL dinamis ke approve.show
            ];
        }

        return [
            'message' => 'Peminjaman anda untuk program ' . $this->peminjaman->program . ' telah selesai.',
            'peminjaman_id' => $this->peminjaman->id_peminjaman,
            'program' => $this->peminjaman->program,
            'type' => 'selesai',
            'url' => $url, // Menambahkan URL dinamis ke approve.show
        ];
    }
}