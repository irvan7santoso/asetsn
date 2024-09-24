<?php

namespace App\Notifications;

use App\Mail\PeminjamanSelesaiMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class PeminjamanSelesai extends Notification implements ShouldQueue
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
        // Menggunakan 'mail' dan 'database' sebagai channel notifikasi
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        if ($this->isAdmin) {
            // Jika notifikasi untuk admin, kirim ke email admin dari tabel users
            return (new PeminjamanSelesaiMailable($this->peminjaman, $this->isAdmin))
                        ->to($notifiable->email); // Email admin dari tabel users
        } else {
            // Jika notifikasi untuk peminjam, kirim ke email_peminjam dari tabel peminjaman
            return (new PeminjamanSelesaiMailable($this->peminjaman, $this->isAdmin))
                        ->to($this->peminjaman->email_peminjam); // Email peminjam dari tabel peminjaman
        }
    }

    public function toDatabase($notifiable)
    {
        if ($this->isAdmin) {
            // URL untuk admin
            $url = route('approve.show', ['id' => $this->peminjaman->id_peminjaman]);

            return [
                'message' => 'Peminjaman oleh ' . $this->peminjaman->nama_peminjam . ' telah selesai.',
                'peminjaman_id' => $this->peminjaman->id_peminjaman,
                'nama_peminjam' => $this->peminjaman->nama_peminjam,
                'program' => $this->peminjaman->program,
                'type' => 'selesai',
                'url' => $url,
            ];
        } else {
            // URL untuk peminjam
            $url = route('peminjaman.userShow', ['id' => $this->peminjaman->id_peminjaman]);

            return [
                'message' => 'Peminjaman anda untuk program ' . $this->peminjaman->program . ' telah selesai.',
                'peminjaman_id' => $this->peminjaman->id_peminjaman,
                'program' => $this->peminjaman->program,
                'type' => 'selesai',
                'url' => $url,
            ];
        }
    }
}
