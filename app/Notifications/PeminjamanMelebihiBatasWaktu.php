<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeminjamanMelebihiBatasWaktu extends Notification
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
        return ['database'];  // Menambahkan channel 'database'
    }

    public function toDatabase($notifiable)
    {
        if ($this->isAdmin) {
            return [
                'message' => 'Peminjaman ' . $this->peminjaman->nama_peminjam . ' untuk program ' . $this->peminjaman->program . ' telah melebihi batas waktu.',
                'peminjaman_id' => $this->peminjaman->id_peminjaman,
                'nama_peminjam' => $this->peminjaman->nama_peminjam,
                'program' => $this->peminjaman->program,
                'type' => 'overdue',
            ];
        }

        return [
            'message' => 'Peminjaman anda untuk program ' . $this->peminjaman->program . ' telah melebihi batas waktu.',
            'peminjaman_id' => $this->peminjaman->id_peminjaman,
            'program' => $this->peminjaman->program,
            'type' => 'overdue',
        ];
    }
}
