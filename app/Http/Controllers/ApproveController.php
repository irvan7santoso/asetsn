<?php

namespace App\Http\Controllers;

use App\Models\Asettlsn;
use App\Models\ItemPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'Semua'); // Default to 'Semua' if no status is provided
        
        if ($status === 'Semua') {
            $peminjaman = Peminjaman::orderBy('created_at', 'desc')->get();
        } else {
            $peminjaman = Peminjaman::where('status', $status)->orderBy('created_at', 'desc')->get();
        }

        return view('approve.daftar', compact('peminjaman', 'status'));
    }


    public function userIndex(Request $request)
    {
        $user = auth()->user(); // Mendapatkan user yang sedang login
        $status = $request->input('status', 'Semua'); // Mendapatkan status dari request atau default ke 'Semua'

        // Jika status adalah 'Semua', ambil semua data peminjaman berdasarkan user
        if ($status === 'Semua') {
            $peminjaman = Peminjaman::where('id_user', $user->id)->orderBy('created_at', 'desc')->get();
        } else {
            $peminjaman = Peminjaman::where('id_user', $user->id)
                            ->where('status', $status)
                            ->get(); // Mengambil data peminjaman berdasarkan user dan status
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

        if ($request->input('action') == 'terima_pengembalian') {
            $status = 'Selesai';
        }

        if ($status === 'Disetujui') {
            foreach ($peminjaman->asettlsns as $asset) {
                $item = ItemPeminjaman::where('id_peminjaman', $peminjaman->id_peminjaman)
                                    ->where('id_aset', $asset->id)
                                    ->first();
                if ($item) {
                    $asset->reduceStock($item->jumlah_dipinjam);
                }
            }
        }

        if ($status !== 'Selesai' && $peminjaman->tgl_kembali < now()) {
            $peminjaman->status = 'Melebihi batas waktu';
        } else {
            $peminjaman->status = $status;
        }

        $peminjaman->save();

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

        $peminjaman->save();

        return redirect()->route('peminjaman.user', ['status' => 'Pending'])->with('success', 'Status permohonan berhasil diperbarui.');
    }
}
