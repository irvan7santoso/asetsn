@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="container-fluid">
        <div class="panel">
            <div class="panel-body">
            <h1>Daftar Peminjaman Aset</h1>
            <table class="table table-hover">
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
                        <td>{{ $pinjam->tgl_peminjaman }}</td>
                        <td>{{ $pinjam->tgl_kembali }}</td>
                        <td>
                            <span class="label label-{{ 
                                $pinjam->status == 'Disetujui' ? 'primary' : (
                                $pinjam->status == 'Pending' ? 'warning' : (
                                $pinjam->status == 'Ditolak' || $pinjam->status == 'Melewati Batas Waktu' ? 'danger' : (
                                $pinjam->status == 'Selesai' ? 'success' : ''
                                ))) }}">
                                {{ ucfirst($pinjam->status) }}
                                </span>
                        </td>
                        <td><a href="{{ route('approve.show', $pinjam->id_peminjaman) }}" class="btn btn-success">Detail</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection
