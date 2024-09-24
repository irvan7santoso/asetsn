<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PeminjamanBaruNotification extends Notification
{
    use Queueable;

    public $peminjaman;

    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    // Menentukan channel yang akan digunakan, dalam hal ini menggunakan database
    public function via($notifiable)
    {
        return ['database'];
    }

    // Isi data notifikasi yang akan disimpan ke database
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
            'url' => route('approve.show', $this->peminjaman->id_peminjaman), // URL ke detail peminjaman menggunakan route approve
        ];
    }    
}
