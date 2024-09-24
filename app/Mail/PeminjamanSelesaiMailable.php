<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeminjamanSelesaiMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $isAdmin;

    /**
     * Create a new message instance.
     *
     * @param $peminjaman
     * @param bool $isAdmin
     */
    public function __construct($peminjaman, $isAdmin = false)
    {
        $this->peminjaman = $peminjaman;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->isAdmin
            ? 'Peminjaman Telah Selesai'
            : 'Peminjaman Anda Telah Selesai';

        return $this->view('email.peminjamanselesai')
            ->subject($subject)
            ->with([
                'peminjaman' => $this->peminjaman,
                'isAdmin' => $this->isAdmin,
            ]);
    }
}
