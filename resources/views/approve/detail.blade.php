@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="container-fluid">
        <div class="panel">
            <div class="panel-body">
                <h2>Detail Permohonan Peminjaman</h2>
                <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
                <p><strong>Nomor HP Peminjam:</strong> {{ $peminjaman->nomor_hp_peminjam }}</p>
                <p><strong>Email Peminjam:</strong> {{ $peminjaman->email_peminjam }}</p>

                @if(empty($peminjaman->judul_kegiatan) && empty($peminjaman->lokasi_kegiatan))
                    <p><strong>Alasan Peminjaman:</strong> {{ $peminjaman->program }}</p>
                @else
                    <p><strong>Program:</strong> {{ $peminjaman->program }}</p>
                    @if(!empty($peminjaman->judul_kegiatan))
                        <p><strong>Judul Kegiatan:</strong> {{ $peminjaman->judul_kegiatan }}</p>
                    @endif
                    @if(!empty($peminjaman->lokasi_kegiatan))
                        <p><strong>Lokasi Kegiatan:</strong> {{ $peminjaman->lokasi_kegiatan }}</p>
                    @endif
                @endif

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

                @if (in_array($peminjaman->status, ['Pending', 'Disetujui', 'Ditolak']))
                    <div class="form-group">
                        <label for="status">Status</label>
                        <div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="tolak" value="Ditolak" {{ $peminjaman->status == 'Ditolak' ? 'checked' : '' }}>
                                <label class="form-check-label" for="tolak">
                                    Tolak
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="setuju" value="Disetujui" {{ $peminjaman->status == 'Disetujui' ? 'checked' : '' }}>
                                <label class="form-check-label" for="setuju">
                                    Setuju
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-right">
                    <a href="{{ route('approve.index') }}" class="btn btn-primary mt-3">Kembali</a>
                    @if ($peminjaman->status != 'Selesai')
                        @if ($peminjaman->status == 'Pengembalian')
                            <button type="submit" name="action" value="terima_pengembalian" class="btn btn-success">Terima Pengembalian</button>
                        @else
                            <button type="submit" class="btn btn-success">Submit</button>
                        @endif
                    @endif
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
.form-check-inline {
    display: inline-block;
    margin-right: 10px;
}
</style>
@endsection
