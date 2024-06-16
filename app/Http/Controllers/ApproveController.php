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
        $status = $request->input('status', 'Pending'); // Default to 'Pending' if no status is provided
        $peminjaman = Peminjaman::where('status', $status)->orderBy('created_at', 'desc')->get();
        return view('approve.daftar', compact('peminjaman'));
    }

    public function userIndex(Request $request)
    {
        $user = auth()->user(); // Mendapatkan user yang sedang login
        $status = $request->input('status', 'Pending'); // Mendapatkan status dari request atau default ke 'Pending'

        $peminjaman = Peminjaman::where('id_user', $user->id)
                        ->where('status', $status)
                        ->get(); // Mengambil data peminjaman berdasarkan user dan status

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
        $peminjaman->status = $request->input('status');
        $peminjaman->catatan = $request->input('catatan');

        if ($request->input('status') === 'Disetujui') {
            foreach ($peminjaman->asettlsns as $asset) {
                $item = ItemPeminjaman::where('id_peminjaman', $peminjaman->id_peminjaman)
                                      ->where('id_aset', $asset->id)
                                      ->first();
        
                if ($item) {
                    $asset->reduceStock($item->jumlah_dipinjam);
                }
            }
        }

        if ($request->input('status') === 'Selesai') {
            foreach ($peminjaman->asettlsns as $asset) {
                $item = ItemPeminjaman::where('id_peminjaman', $peminjaman->id_peminjaman)
                                      ->where('id_aset', $asset->id)
                                      ->first();
        
                if ($item) {
                    $asset->increaseStock($item->jumlah_dipinjam);
                }
            }
        }
        
        if ($peminjaman->tgl_kembali < now() && $request->input('status') !== 'Selesai') {
            $peminjaman->status = 'Melebihi batas waktu';
        }
        
        $peminjaman->save();

        return redirect()->route('approve.index')->with('success', 'Status permohonan berhasil diperbarui.');
    }
}
