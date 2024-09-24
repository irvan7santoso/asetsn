<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Carbon\Carbon;

class UpdatePeminjamanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'peminjaman:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status peminjaman jika melewati batas waktu atau sudah selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Mendapatkan semua peminjaman yang statusnya masih "Dipinjam" atau "Pending", "Disetujui"
        $today = Carbon::today();

        // Ubah status "Dipinjam" menjadi "Melebihi batas waktu" jika sudah melewati tanggal kembali
        Peminjaman::where('status', 'Dipinjam')
            ->where('tgl_kembali', '<', $today)
            ->update(['status' => 'Melebihi batas waktu']);

        // Ubah status "Pending" atau "Disetujui" menjadi "Selesai" jika sudah mencapai tanggal kembali
        Peminjaman::whereIn('status', ['Pending', 'Disetujui'])
            ->where('tgl_kembali', '<=', $today)
            ->update(['status' => 'Selesai']);

        // Ubah status "Pending" menjadi "Expired" jika sudah melebihi tanggal peminjaman
        Peminjaman::where('status', 'Pending')
            ->where('tgl_peminjaman', '<', $today)
            ->update(['status' => 'Expired']);

        $this->info('Status peminjaman telah diperbarui.');
    }
}
