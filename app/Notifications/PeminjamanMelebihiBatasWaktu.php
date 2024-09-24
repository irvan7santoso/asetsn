<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\PeminjamanMelebihiBatasWaktuMailable;
use Illuminate\Notifications\Messages\MailMessage;

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
        return ['database', 'mail'];
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

    public function toArray($notifiable)
    {
        if ($this->isAdmin) {
            // Redirect untuk admin ke halaman approve
            return [
                'message' => 'Peminjaman ' . $this->peminjaman->nama_peminjam . ' untuk program ' . $this->peminjaman->program . ' telah melebihi batas waktu.',
                'url' => route('approve.show', ['id' => $this->peminjaman->id_peminjaman]),
            ];
        }

        // Redirect untuk peminjam ke halaman peminjaman user
        return [
            'message' => 'Peminjaman anda untuk program ' . $this->peminjaman->program . ' telah melebihi batas waktu.',
            'url' => route('peminjaman.userShow', ['id' => $this->peminjaman->id_peminjaman]),
        ];
    }

    public function toMail($notifiable)
    {
        if ($this->isAdmin) {
            // Jika notifikasi untuk admin, kirim ke email admin dari tabel users
            return (new PeminjamanMelebihiBatasWaktuMailable($this->peminjaman, $this->isAdmin))
                        ->to($notifiable->email); // Email admin dari tabel users
        } else {
            // Jika notifikasi untuk peminjam, kirim ke email_peminjam dari tabel peminjaman
            return (new PeminjamanMelebihiBatasWaktuMailable($this->peminjaman, $this->isAdmin))
                        ->to($this->peminjaman->email_peminjam); // Email peminjam dari tabel peminjaman
        }
    }
}
