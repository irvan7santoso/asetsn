<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asettlsn;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\ItemPeminjaman;
use App\Notifications\PengembalianNotification;
use App\Notifications\PeminjamanUserSTNotification;

class ApproveController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'Semua'); // Default to 'Semua' jika tidak ada status yang diberikan
        
        if ($status === 'Semua') {
            $peminjaman = Peminjaman::orderBy('created_at', 'desc')->paginate(10); // Tambahkan pagination
        } else {
            $peminjaman = Peminjaman::where('status', $status)->orderBy('created_at', 'desc')->paginate(10); // Tambahkan pagination
        }
    
        return view('approve.daftar', compact('peminjaman', 'status'));
    }

    public function userIndex(Request $request)
    {
        $user = auth()->user(); // Mendapatkan user yang sedang login
        $status = $request->input('status', 'Semua'); // Mendapatkan status dari request atau default ke 'Semua'

        // Jika status adalah 'Semua', ambil semua data peminjaman berdasarkan user
        if ($status === 'Semua') {
            $peminjaman = Peminjaman::where('id_user', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $peminjaman = Peminjaman::where('id_user', $user->id)
                            ->where('status', $status)
                            ->paginate(10); // Mengambil data peminjaman berdasarkan user dan status
        }

        return view('peminjaman.daftaruser', compact('peminjaman', 'status'));
    }


    public function show($id)
    {
        $peminjaman = Peminjaman::with('asettlsns')->findOrFail($id);
        return view('approve.detail', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('asettlsns')->findOrFail($id);
        $status = $request->input('status');
        $peminjaman->catatan = $request->input('catatan');
        
        // Update status
        if ($request->input('action') == 'terima_pengembalian') {
            $status = 'Selesai';
        }
    
        if ($status === 'Disetujui') {
            foreach ($peminjaman->asettlsns as $asset) {
                $item = ItemPeminjaman::where('id_peminjaman', $peminjaman->id_peminjaman)
                                    ->where('id_aset', $asset->id)
                                    ->first();
                if ($item) {
                    $asset->reduceStock($item->jumlah_dipinjam); // Mengurangi stok aset
                }
            }
        }
    
        // Atur status "Melebihi batas waktu" jika status adalah 'Dipinjam' dan tgl_kembali sudah lewat
        if ($peminjaman->status === 'Dipinjam' && $peminjaman->tgl_kembali < now()) {
            $peminjaman->status = 'Melebihi batas waktu';
        } 
        
        // Atur status "Expired" jika status "Pending" atau "Disetujui" dan sudah lewat tgl_peminjaman
        elseif (in_array($peminjaman->status, ['Pending', 'Disetujui']) && $peminjaman->tgl_peminjaman < now()) {
            $peminjaman->status = 'Expired';
        } 
        
        // Jika tidak ada kondisi di atas, tetap update status dari input
        else {
            $peminjaman->status = $status;
        }

        $peminjaman->save();

    
        // Kirim notifikasi hanya jika status adalah 'Disetujui' atau 'Ditolak'
        if (in_array($status, ['Disetujui', 'Ditolak'])) {
            $user = $peminjaman->user;  // Mengambil user yang melakukan peminjaman
            $user->notify(new PeminjamanUserSTNotification($peminjaman, $status));
        }
    
        return redirect()->route('approve.index')->with('success', 'Status permohonan berhasil diperbarui.');
    }


    public function userShow($id)
    {
        $user = auth()->user();
        $peminjaman = Peminjaman::with('asettlsns')->where('id_peminjaman', $id)->where('id_user', $user->id)->firstOrFail();
        return view('peminjaman.detailuser', compact('peminjaman'));
    }

    
    public function userUpdate(Request $request, $id)
    {
        $user = auth()->user();
        $peminjaman = Peminjaman::with('asettlsns')->where('id_peminjaman', $id)->where('id_user', $user->id)->firstOrFail();

        if ($request->input('action') == 'kembalikan') {
            // Update status to "Pengembalian"
            $peminjaman->status = 'Pengembalian';
            // Kirim notifikasi ke admin
            $admins = User::where('role', 'admin')->get(); // Asumsi admin memiliki role 'admin'
            foreach ($admins as $admin) {
                $admin->notify(new PengembalianNotification($peminjaman));
            }
        } elseif ($request->input('action') == 'batalkan_pengembalian') {
            // Update status to "Dipinjam"
            $peminjaman->status = 'Dipinjam';
        } else {
            $userStatus = $request->input('status');
            if ($userStatus === 'Disetujui') {
                if ($peminjaman->status === 'Disetujui') {
                    $peminjaman->status = 'Dipinjam';
                }
            } else if ($userStatus === 'Ditolak') {
                $peminjaman->status = 'Ditolak';
            }
        }

         // Atur status "Melebihi batas waktu" jika status adalah 'Dipinjam' dan tgl_kembali sudah lewat
        if ($peminjaman->status === 'Dipinjam' && $peminjaman->tgl_kembali < now()) {
            $peminjaman->status = 'Melebihi batas waktu';
        } 
        
        // Atur status "Expired" jika status "Pending" atau "Disetujui" dan sudah lewat tgl_peminjaman
        elseif (in_array($peminjaman->status, ['Pending', 'Disetujui']) && $peminjaman->tgl_peminjaman < now()) {
            $peminjaman->status = 'Expired';
        }

        $peminjaman->save();

        return redirect()->route('peminjaman.user', ['status' => 'Semua'])->with('success', 'Status permohonan berhasil diperbarui.');
    }
}
