@extends('layouts.main')

@section('container')
<div class="main-content">
    @include('layouts.alert')
        <div class="container-fluid">
            <!-- TABLE HOVER -->
            <div class="panel">
            <div class="panel-body">
                <h1>Form Peminjaman Aset</h1>
                <form action="/peminjaman" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_peminjam">Nama Peminjam</label>
                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_hp">Nomor HP</label>
                        <input type="text" class="form-control" id="nomor_hp_peminjam" name="nomor_hp_peminjam" required>
                    </div>
                    <div class="form-group">
                        <label for="program">Program</label>
                        <input type="text" class="form-control" id="program" name="program" required>
                    </div>
                    <div class="form-group">
                        <label for="judul_kegiatan">Judul Kegiatan</label>
                        <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_kegiatan">Lokasi Kegiatan</label>
                        <input type="text" class="form-control" id="lokasi_kegiatan" name="lokasi_kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
                        <input type="date" class="form-control" id="tgl_peminjaman" name="tgl_peminjaman" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                        <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" required>
                    </div>
                    <div class="form-group">
                        <label for="lampiran">Lampiran</label>
                        <input type="file" class="form-control" id="lampiran" name="lampiran">
                    </div>
                    
                    <h3>Aset yang akan dipinjam</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Aset</th>
                                <th>Jumlah Dipinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedAssets as $asset)
                            <tr>
                                <td>{{ $asset->namabarang }}</td>
                                <td>
                                    <input type="hidden" name="barang[{{ $asset->id }}][id]" value="{{ $asset->id }}">
                                    <input type="number" name="barang[{{ $asset->id }}][jumlah_dipinjam]" class="form-control" max="{{ $asset->jumlah_tersedia }}" required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                    <a href="/peminjaman" class="btn btn-primary mt-3">Kembali</a>
                    <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
