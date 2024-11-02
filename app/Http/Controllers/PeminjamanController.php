<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Program;
use App\Models\Asettlsn;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\ItemPeminjaman;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PeminjamanBaruNotification;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        
        if (strlen($katakunci)) {
            $assets = Asettlsn::where('namabarang', 'ILIKE', "%$katakunci%")
                ->where('jumlah_tersedia', '>', 0)
                ->paginate(10); // Batasi 10 data per halaman
        } else {
            $assets = Asettlsn::where('kondisi', 'Baik')
                ->where('jumlah_tersedia', '>', 0)
                ->paginate(10); // Batasi 10 data per halaman
        }

        $cart = session('cart', []); // Ambil keranjang dari session

        return view('peminjaman.daftar', compact('assets', 'cart'));
    }

    public function create(Request $request)
    {
        $selectedAssetsData = $request->input('pinjam_barang', []);
        $selectedAssets = [];

        foreach ($selectedAssetsData as $data) {
            $asset = Asettlsn::find($data['id']);
            if ($asset) {
                $asset->jumlah_dipinjam = $data['jumlah_dipinjam'];
                $selectedAssets[] = $asset;
            }
        }

        $programs = Program::all(); // Ambil semua data program

        return view('peminjaman.create', compact('selectedAssets', 'programs'));
    }


    public function store(Request $request)
    {
        $currentDate = now()->startOfDay();

        $rules = [
            'jenis_peminjam' => 'required|in:karyawan,non_karyawan',
            'tgl_peminjaman' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($currentDate) {
                    $minDate = $currentDate->copy()->addDays(3);
                    if (Carbon::parse($value)->lt($minDate)) {
                        $fail('Tanggal peminjaman harus H+3 dari tanggal permohonan.');
                    }
                }
            ],
            'tgl_kembali' => [
                'required',
                'date',
                'after_or_equal:tgl_peminjaman'
            ],
            'lampiran' => 'required|file|mimes:jpg,jpeg,png|max:2048',  // Lampiran harus berupa gambar
            'barang' => 'required|array',
            'barang.*.id' => 'required|integer|exists:asettlsn,id',
            'barang.*.jumlah_dipinjam' => 'required|integer|min:1',
        ];

        if ($request->jenis_peminjam == 'karyawan') {
            $rules['program'] = 'required|string|max:255';
        } else {
            $rules['program_non_karyawan'] = 'required|string|max:255';
        }

        $validatedData = $request->validate($rules);

        // Tentukan data peminjam berdasarkan jenis
        if ($request->jenis_peminjam == 'karyawan') {
            $nama_peminjam = $request->nama_karyawan;
            $nomor_hp_peminjam = $request->nomor_hp_karyawan;
            $email_peminjam = Auth::user()->email;
            $program = $validatedData['program'] ?? '';
            $judul_kegiatan = $request->judul_kegiatan ?? '';
            $lokasi_kegiatan = $request->lokasi_kegiatan ?? '';
        } else {
            $nama_peminjam = $request->nama_peminjam;
            $nomor_hp_peminjam = $request->nomor_hp_peminjam;
            $email_peminjam = $request->email_peminjam;
            $program = $validatedData['program_non_karyawan'] ?? '';
            $judul_kegiatan = $validatedData['judul_kegiatan_non_karyawan'] ?? '';
            $lokasi_kegiatan = $validatedData['lokasi_kegiatan_non_karyawan'] ?? '';
        }

        // Buat instance peminjaman baru
        $peminjaman = new Peminjaman();
        $peminjaman->nama_peminjam = $nama_peminjam;
        $peminjaman->nomor_hp_peminjam = $nomor_hp_peminjam;
        $peminjaman->email_peminjam = $email_peminjam;
        $peminjaman->program = $program;
        $peminjaman->judul_kegiatan = $judul_kegiatan;
        $peminjaman->lokasi_kegiatan = $lokasi_kegiatan;
        $peminjaman->tgl_peminjaman = $validatedData['tgl_peminjaman'];
        $peminjaman->tgl_kembali = $validatedData['tgl_kembali'];
        $peminjaman->id_user = auth()->id();
        $peminjaman->save(); // Simpan terlebih dahulu untuk mendapatkan id_peminjaman

        // Proses lampiran dengan nama kustom berdasarkan id_peminjaman
        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran');
            $extension = $lampiran->getClientOriginalExtension();
            $filename = 'lampiran-' . $peminjaman->id_peminjaman . '.' . $extension; // Nama file: lampiran-id_peminjaman.jpg
            $path = $lampiran->storeAs('lampiran', $filename, 'public');
            $peminjaman->lampiran = $path; // Simpan path file di database
            $peminjaman->save(); // Simpan ulang dengan path lampiran yang benar
        }

        // Simpan item peminjaman
        foreach ($validatedData['barang'] as $barang) {
            $itemPeminjaman = new ItemPeminjaman();
            $itemPeminjaman->id_aset = $barang['id'];
            $itemPeminjaman->id_peminjaman = $peminjaman->id_peminjaman;
            $itemPeminjaman->jumlah_dipinjam = $barang['jumlah_dipinjam'];
            $itemPeminjaman->save();
        }

        // Kirim notifikasi ke admin
        $admins = User::where('role', 'admin')->get(); // Ambil semua user yang memiliki peran admin
        foreach ($admins as $admin) {
            $admin->notify(new PeminjamanBaruNotification($peminjaman));
        }

        // Hapus keranjang setelah peminjaman berhasil
        session()->forget('cart');

        return redirect('/peminjaman')->with('success', 'Permohonan peminjaman berhasil dibuat, mohon tunggu permohonan disetujui.');
    }

}
