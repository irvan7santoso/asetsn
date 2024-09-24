<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeminjamanUserSTMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $status;

    public function __construct($peminjaman, $status)
    {
        $this->peminjaman = $peminjaman;
        $this->status = $status;
    }

    public function build()
    {
        $namaPeminjam = $this->peminjaman->nama_peminjam;
        $tglPeminjaman = $this->peminjaman->tgl_peminjaman;
        $tglKembali = $this->peminjaman->tgl_kembali;
        $peminjamanId = $this->peminjaman->id_peminjaman;

        if ($this->status === 'Disetujui') {
            $message = "Peminjaman oleh $namaPeminjam pada $tglPeminjaman s/d $tglKembali telah disetujui.";
        } elseif ($this->status === 'Ditolak') {
            $message = "Peminjaman oleh $namaPeminjam pada $tglPeminjaman s/d $tglKembali ditolak.";
        }

        $url = route('peminjaman.userShow', ['id' => $peminjamanId]);

        return $this->subject('Update Permohonan Peminjaman')
                    ->markdown('email.peminjamanst')
                    ->with([
                        'message' => $message,
                        'url' => $url,
                    ]);
    }
}
