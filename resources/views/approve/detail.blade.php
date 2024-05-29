@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="container-fluid">
        <div class="panel">
            <div class="panel-body">
                <h2>Detail Permohonan Peminjaman</h1>
                <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
                <p><strong>Nomor HP Peminjam:</strong> {{ $peminjaman->nomor_hp_peminjam }}</p>
                <p><strong>Program:</strong> {{ $peminjaman->program }}</p>
                <p><strong>Judul Kegiatan:</strong> {{ $peminjaman->judul_kegiatan }}</p>
                <p><strong>Lokasi Kegiatan:</strong> {{ $peminjaman->lokasi_kegiatan }}</p>
                <p><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tgl_peminjaman }}</p>
                <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tgl_kembali }}</p>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <h2>Daftar Aset yang Dipinjam</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman->asettlsns as $aset)
                        <tr>
                            <td>{{ $aset->namabarang }}</td>
                            <td>{{ $aset->pivot->jumlah_dipinjam }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="{{ route('approve.update', $peminjaman->id_peminjaman) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ $peminjaman->catatan }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Pending" {{ $peminjaman->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Ditolak" {{ $peminjaman->status == 'Ditolak' ? 'selected' : '' }}>Tolak</option>
                        <option value="Disetujui" {{ $peminjaman->status == 'Disetujui' ? 'selected' : '' }}>Setuju</option>
                        <option value="Selesai" {{ $peminjaman->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="text-right">
                <a href="{{ route('approve.index') }}" class="btn btn-primary mt-3">Kembali</a>
                <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
