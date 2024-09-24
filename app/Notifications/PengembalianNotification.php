<?php

namespace App\Notifications;

use App\Mail\PengembalianMailable;
use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengembalianNotification extends Notification
{
    use Queueable;

    protected $peminjaman;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail']; // Kirim notifikasi via database
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Pengembalian oleh ' . $this->peminjaman->nama_peminjam,
            'peminjaman_id' => $this->peminjaman->id_peminjaman,
            // Ubah URL ke route 'approve.show'
            'url' => route('approve.show', ['id' => $this->peminjaman->id_peminjaman]), 
        ];
    }

    public function toMail($notifiable)
    {
        return (new PengembalianMailable($this->peminjaman))->to($notifiable->email);
    }
}