@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="container-fluid">
        <div class="panel">
            <div class="panel-body">
            <h1>Daftar Peminjaman Saya</h1>
            <div class="btn-group" role="group">
                <a href="{{ route('peminjaman.user', ['status' => 'Semua']) }}" class="btn btn-default {{ request('status', 'Semua') == 'Semua' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('peminjaman.user', ['status' => 'Pending']) }}" class="btn btn-default {{ request('status') == 'Pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('peminjaman.user', ['status' => 'Disetujui']) }}" class="btn btn-default {{ request('status') == 'Disetujui' ? 'active' : '' }}">Disetujui</a>
                <a href="{{ route('peminjaman.user', ['status' => 'Ditolak']) }}" class="btn btn-default {{ request('status') == 'Ditolak' ? 'active' : '' }}">Ditolak</a>
                <a href="{{ route('peminjaman.user', ['status' => 'Dipinjam']) }}" class="btn btn-default {{ request('status') == 'Dipinjam' ? 'active' : '' }}">Dipinjam</a>
                <a href="{{ route('peminjaman.user', ['status' => 'Pengembalian']) }}" class="btn btn-default {{ request('status') == 'Pengembalian' ? 'active' : '' }}">Pengembalian</a>
                <a href="{{ route('peminjaman.user', ['status' => 'Selesai']) }}" class="btn btn-default {{ request('status') == 'Selesai' ? 'active' : '' }}">Selesai</a>
                <a href="{{ route('peminjaman.user', ['status' => 'Melewati Batas Waktu']) }}" class="btn btn-default {{ request('status') == 'Melewati Batas Waktu' ? 'active' : '' }}">Melewati Batas Waktu</a>
            </div>

            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Program</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $pinjam)
                    <tr>
                        <td>{{ $pinjam->nama_peminjam }}</td>
                        <td>{{ $pinjam->program }}</td>
                        <td>{{ \Carbon\Carbon::parse($pinjam->tgl_peminjaman)->isoFormat('D MMMM YYYY') }}</td>
                        <td>{{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->isoFormat('D MMMM YYYY') }}</td>
                        <td>
                            <span class="label label-{{ 
                                $pinjam->status == 'Pending' ? 'pending' : (
                                $pinjam->status == 'Disetujui' ? 'disetujui' : (
                                $pinjam->status == 'Dipinjam' ? 'dipinjam' : (
                                $pinjam->status == 'Pengembalian' ? 'pengembalian' : (
                                $pinjam->status == 'Selesai' ? 'selesai' : (
                                $pinjam->status == 'Ditolak' ? 'ditolak' : (
                                $pinjam->status == 'Melewati Batas Waktu' ? 'melewati-batas-waktu' : ''
                                )))))) }}">
                                {{ ucfirst($pinjam->status) }}
                            </span>
                        </td>
                        <td><a href="{{ route('peminjaman.userShow', ['id' => $pinjam->id_peminjaman]) }}" class="btn btn-success">Detail</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<style>
.btn-group .btn {
    background-color: #327e33; /* Warna latar belakang tombol tidak aktif */
    border-color: #c9c9c9; /* Warna batas tombol tidak aktif */
    color: #ffffff; /* Warna teks tombol tidak aktif */
}

.btn-group .btn:hover {
    background-color: #1dc81f; /* Warna latar belakang saat hover */
    border-color: #adadad; /* Warna batas saat hover */
    color: #ffffff; /* Warna teks saat hover */
}

.btn-group .btn.active {
    background-color: #1dc81f; /* Warna latar belakang untuk tombol aktif */
    border-color: #adadad; /* Warna batas untuk tombol aktif */
    color: #ffffff; /* Warna teks untuk tombol aktif */
}

.label-pending {
    background-color: #d3d3d3; /* Warna abu-abu */
    color: #000; /* Warna teks */
}

.label-disetujui {
    background-color: #007bff; /* Warna biru */
    color: #fff; /* Warna teks */
}

.label-dipinjam {
    background-color: #ffeb3b; /* Warna kuning */
    color: #000; /* Warna teks */
}

.label-pengembalian {
    background-color: #ff9800; /* Warna oren */
    color: #fff; /* Warna teks */
}

.label-selesai {
    background-color: #28a745; /* Warna hijau */
    color: #fff; /* Warna teks */
}

.label-ditolak,
.label-melewati-batas-waktu {
    background-color: #dc3545; /* Warna merah */
    color: #fff; /* Warna teks */
}
</style>
@endsection
