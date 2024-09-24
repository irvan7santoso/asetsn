<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeminjamanBaruMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Permohonan Peminjaman Baru')
                    ->view('email.peminjamanbaru') // Tentukan view email
                    ->with([
                        'nama_peminjam' => $this->peminjaman->nama_peminjam,
                        'program' => $this->peminjaman->program,
                        'tgl_peminjaman' => $this->peminjaman->tgl_peminjaman,
                        'tgl_kembali' => $this->peminjaman->tgl_kembali,
                        'url' => route('approve.show', $this->peminjaman->id_peminjaman),
                    ]);
    }
}