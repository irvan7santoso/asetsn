<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeminjamanMelebihiBatasWaktuMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $isAdmin;

    /**
     * Create a new message instance.
     *
     * @return void
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
            ? 'Peminjaman Melebihi Batas Waktu untuk Program ' . $this->peminjaman->program 
            : 'Peminjaman Anda Melebihi Batas Waktu';
    
        // Menentukan URL berdasarkan admin atau peminjam
        $url = $this->isAdmin
            ? route('approve.show', ['id' => $this->peminjaman->id_peminjaman])
            : route('peminjaman.userShow', ['id' => $this->peminjaman->id_peminjaman]);
    
        return $this->subject($subject)
                    ->view('email.peminjamanmelebihibataswaktu')
                    ->with([
                        'peminjaman' => $this->peminjaman,
                        'isAdmin' => $this->isAdmin,
                        'url' => $url, // Menambahkan URL ke view
                    ]);
    }
}
