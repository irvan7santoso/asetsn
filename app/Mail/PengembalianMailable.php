<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengembalianMailable extends Mailable
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
        return $this->subject('Notifikasi Pengembalian')
                    ->view('email.pengembalian')
                    ->with([
                        'nama_peminjam' => $this->peminjaman->nama_peminjam,
                        'program' => $this->peminjaman->program, // tambahkan ini
                        'tgl_peminjaman' => $this->peminjaman->tgl_peminjaman, // tambahkan ini
                        'tgl_kembali' => $this->peminjaman->tgl_kembali, // tambahkan ini
                        'url' => route('approve.show', ['id' => $this->peminjaman->id_peminjaman]),
                    ]);
    }
}
