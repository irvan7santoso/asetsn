<?php

namespace App\Notifications;

use App\Mail\PeminjamanBaruMailable;
use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class PeminjamanBaruNotification extends Notification
{
    use Queueable;

    public $peminjaman;

    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Menggunakan mail dan database sebagai channel
    }

    // Kirim notifikasi melalui email
    public function toMail($notifiable)
    {
        // Mengembalikan instance dari Mailable, bukan memanggil Mail::send() secara manual
        return (new PeminjamanBaruMailable($this->peminjaman))
                ->to($notifiable->email); // Pastikan email dikirim ke admin
    }

    // Simpan notifikasi ke database
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Peminjaman baru oleh ' . $this->peminjaman->nama_peminjam . 
                         ' untuk program ' . $this->peminjaman->program . 
                         ' dari ' . $this->peminjaman->tgl_peminjaman .
                         ' s/d ' . $this->peminjaman->tgl_kembali,
            'id_peminjaman' => $this->peminjaman->id_peminjaman,
            'nama_peminjam' => $this->peminjaman->nama_peminjam,
            'program' => $this->peminjaman->program,
            'tgl_peminjaman' => $this->peminjaman->tgl_peminjaman,
            'tgl_kembali' => $this->peminjaman->tgl_kembali,
            'status' => $this->peminjaman->status,
            'url' => route('approve.show', $this->peminjaman->id_peminjaman),
        ];
    }
}