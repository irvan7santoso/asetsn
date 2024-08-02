@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="container-fluid">
        <div class="panel">
            <div class="panel-body">
                <h2>Detail Permohonan Peminjaman</h2>
                <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
                <p><strong>Nomor HP Peminjam:</strong> {{ $peminjaman->nomor_hp_peminjam }}</p>

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
                <form action="{{ route('peminjaman.userUpdate', ['id' => $peminjaman->id_peminjaman]) }}" method="POST">
                    @csrf
                    @if($peminjaman->status == 'Disetujui')
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
                                    Terima
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($peminjaman->status == 'Dipinjam')
                        <div class="text-right">
                            <a href="{{ route('peminjaman.user', ['status' => 'Pending']) }}" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-warning" name="action" value="kembalikan">Kembalikan</button>
                        </div>
                    @elseif($peminjaman->status == 'Pengembalian')
                        <div class="text-right">
                            <a href="{{ route('peminjaman.user', ['status' => 'Pending']) }}" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-info" name="action" value="batalkan_pengembalian">Batalkan Pengembalian</button>
                        </div>
                    @else
                        <div class="text-right">
                            <a href="{{ route('peminjaman.user', ['status' => 'Pending']) }}" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
