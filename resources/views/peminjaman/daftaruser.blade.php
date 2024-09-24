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
                <a href="{{ route('peminjaman.user', ['status' => 'Melebihi batas waktu']) }}" class="btn btn-default {{ request('status') == 'Melebihi batas waktu' ? 'active' : '' }}">Melebihi batas waktu</a>
                <a href="{{ route('peminjaman.user', ['status' => 'Expired']) }}" class="btn btn-default {{ request('status') == 'Expired' ? 'active' : '' }}">Expired</a>
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
                                $pinjam->status == 'Expired' ? 'expired' : (
                                $pinjam->status == 'Melebihi batas waktu' ? 'melebihibataswaktu' : ''
                                ))))))) }}">
                                {{ ucfirst($pinjam->status) }}
                            </span>
                        </td>
                        <td><a href="{{ route('peminjaman.userShow', ['id' => $pinjam->id_peminjaman]) }}" class="btn btn-success">Detail</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {{ $peminjaman->links() }}
            </div>
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

.label-ditolak {
    background-color: #dc3545; /* Warna merah */
    color: #fff; /* Warna teks */
}

.label-melebihibataswaktu {
    background-color: #000000; /* Warna merah */
    color: #fff; /* Warna teks */
}

.pagination {
display: flex;
justify-content: center;
padding-left: 0px;
margin: -5px 0;
border-radius: 4px;
}
.pagination > li {
display: inline;
}
.pagination > li > a,
.pagination > li > span {
position: relative;
float: left;
padding: 6px 12px;
margin-left: -1px;
line-height: 1.42857143;
color: #327e33;
text-decoration: none;
background-color: #fff;
border: 1px solid #ddd;
}
.pagination > li:first-child > a,
.pagination > li:first-child > span {
margin-left: 0;
border-top-left-radius: 4px;
border-bottom-left-radius: 4px;
}
.pagination > li:last-child > a,
.pagination > li:last-child > span {
border-top-right-radius: 4px;
border-bottom-right-radius: 4px;
}
.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
z-index: 2;
color: #327e33;
background-color: #eee;
border-color: #ddd;
}
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus {
z-index: 3;
color: #fff;
cursor: default;
background-color: #327e33;
border-color: #327e33;
}
.pagination > .disabled > span,
.pagination > .disabled > span:hover,
.pagination > .disabled > span:focus,
.pagination > .disabled > a,
.pagination > .disabled > a:hover,
.pagination > .disabled > a:focus {
color: #777;
cursor: not-allowed;
background-color: #fff;
border-color: #ddd;
}
.pagination-lg > li > a,
.pagination-lg > li > span {
padding: 10px 16px;
font-size: 18px;
line-height: 1.3333333;
}
.pagination-lg > li:first-child > a,
.pagination-lg > li:first-child > span {
border-top-left-radius: 6px;
border-bottom-left-radius: 6px;
}
.pagination-lg > li:last-child > a,
.pagination-lg > li:last-child > span {
border-top-right-radius: 6px;
border-bottom-right-radius: 6px;
}
.pagination-sm > li > a,
.pagination-sm > li > span {
padding: 5px 10px;
font-size: 12px;
line-height: 1.5;
}
.pagination-sm > li:first-child > a,
.pagination-sm > li:first-child > span {
border-top-left-radius: 3px;
border-bottom-left-radius: 3px;
}
.pagination-sm > li:last-child > a,
.pagination-sm > li:last-child > span {
border-top-right-radius: 3px;
border-bottom-right-radius: 3px;
}
.pager {
padding-left: 0;
margin: 20px 0;
text-align: center;
list-style: none;
}
.pager li {
display: inline;
}
.pager li > a,
.pager li > span {
display: inline-block;
padding: 5px 14px;
background-color: #fff;
border: 1px solid #ddd;
border-radius: 15px;
}
.pager li > a:hover,
.pager li > a:focus {
text-decoration: none;
background-color: #eee;
}
.pager .next > a,
.pager .next > span {
float: right;
}
.pager .previous > a,
.pager .previous > span {
float: left;
}
.pager .disabled > a,
.pager .disabled > a:hover,
.pager .disabled > a:focus,
.pager .disabled > span {
color: #777;
cursor: not-allowed;
background-color: #fff;
}
</style>
@endsection
