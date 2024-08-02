@extends('layouts.main')

@section('container')
@php
use App\Models\asettlsn;
@endphp 
@if(Auth::user()->role=='admin')
<script>
	$(function() {
		var data, options;

		//pie charts
		data = {
        labels: ['Rusak : {{ $asetRusak }}', 'Baik : {{ $asetBaik }}', 'Sedang : {{ $asetSedang }}'],
        series: [{{ $asetRusak }}, {{ $asetBaik }}, {{ $asetSedang }}]
    	};

    	options = {
        width: 500,
        height: 300
    	};

    	new Chartist.Pie('#pie-chart', data, options);
	});
</script>
<style>
.ct-label{
    fill:black;
    font-size: 18px;
}

.ct-series-a .ct-slice-pie{
    fill:#ff00008f;
}

.ct-series-b .ct-slice-pie{
    fill:#28ef00a4;
}

.ct-series-c .ct-slice-pie{
    fill:#ffff00a0;
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
    <!-- MAIN CONTENT -->   
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-body">
                    <h1>Dashboard Aset Yayasan Satunama</h1>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="lnr lnr-apartment"></i></span>
                                <p>
                                    <span class="number">{{ asettlsn::count() }}</span>
                                    <span class="title">Jumlah Aset Dimiliki</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="lnr lnr-construction"></i></span>
                                <p>
                                    <span class="number">{{ asettlsn::where('kondisi', 'Rusak')->count() }}</span>
                                    <span class="title">Aset Rusak</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="lnr lnr-users"></i></span>
                                <p>
                                    <span class="number">{{ $asetdipinjam }}</span>
                                    <span class="title">Aset Dipinjam</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="lnr lnr-store"></i></span>
                                <p>
                                    <span class="number">{{ $asetbelumdikembalikan }}</span>
                                    <span class="title">Aset Belum Dikembalikan</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- RECENT PURCHASES -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Peminjaman Terakhir</h3>
                        </div>
                        <div class="panel-body no-padding">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Aset Yang Dipinjam</th>
                                        <th>Waktu Pengajuan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentPeminjaman as $peminjaman)
                                        <tr>
                                            <td>{{ $peminjaman->nama_peminjam }}</td>
                                            <td>
                                                @foreach ($peminjaman->asettlsns as $aset)
                                                    {{ $aset->namabarang }}@if (!$loop->last), @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $peminjaman->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <span class="label label-{{ 
                                                    $peminjaman->status == 'Pending' ? 'pending' : (
                                                    $peminjaman->status == 'Disetujui' ? 'disetujui' : (
                                                    $peminjaman->status == 'Dipinjam' ? 'dipinjam' : (
                                                    $peminjaman->status == 'Pengembalian' ? 'pengembalian' : (
                                                    $peminjaman->status == 'Selesai' ? 'selesai' : (
                                                    $peminjaman->status == 'Ditolak' ? 'ditolak' : (
                                                    $peminjaman->status == 'Melewati Batas Waktu' ? 'melewati-batas-waktu' : ''
                                                    )))))) }}">
                                                    {{ ucfirst($peminjaman->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="text-right"><a href="/approve" class="btn btn-success">Lihat Semua Peminjaman</a></div>
                            </div>
                        </div>
                    </div>
                    <!-- END RECENT PURCHASES -->
                </div>
                <div class="col-md-6">
                    <!-- MULTI CHARTS -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Kondisi Aset</h3>
                        </div>
                        <div class="panel-body">
                            <div id="pie-chart"></div>
                        </div>
                    </div>
                    <!-- END MULTI CHARTS -->
                </div>
            </div>
        </div>
    </div>
<!-- END MAIN -->
@endif
@if(Auth::user()->role=='user')
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <h1> Dashboard Aset Tidak Lancar Yayasan Satunama</h1>
            <div class="panel panel-headline">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="lnr lnr-apartment"></i></span>
                                <p>
                                    <span class="number">{{ asettlsn::count() }}</span>
                                    <span class="title">Jumlah Aset Dimiliki</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="lnr lnr-construction"></i></span>
                                <p>
                                    <span class="number">{{ asettlsn::where('kondisi', 'Rusak')->count() }}</span>
                                    <span class="title">Aset Rusak</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="lnr lnr-users"></i></span>
                                <p>
                                    <span class="number">23</span>
                                    <span class="title">Aset Dipinjam</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <span class="icon"><i class="lnr lnr-store"></i></span>
                                <p>
                                    <span class="number">5</span>
                                    <span class="title">Aset Dikembalikan</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- RECENT PURCHASES -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Peminjaman Terakhir Anda</h3>
                </div>
                <div class="panel-body no-padding">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Aset Yang Dipinjam</th>
                                <th>Tanggal &amp; Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a>1</a></td>
                                <td>Steve</td>
                                <td>Laptop</td>
                                <td>Oct 21, 2016</td>
                                <td><span class="label label-success">Sudah Dikembalikan</span></td>
                            </tr>
                            <tr>
                                <td><a>2</a></td>
                                <td>Mario</td>
                                <td>Sapu</td>
                                <td>Des 30, 2016</td>
                                <td><span class="label label-warning">Belum Dikembalikan</span></td>
                            </tr>
                            <tr>
                                <td><a>3</a></td>
                                <td>Yono</td>
                                <td>Mobil Avanza Veloz</td>
                                <td>Sep 21, 2016</td>
                                <td><span class="label label-danger">Melebihi Batas Peminjaman</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Data Terbaru</span></div>
                        <div class="col-md-6 text-right"><a href="/daftarpeminjamanaset" class="btn btn-success">Lihat Semua Peminjaman</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- END MAIN -->
@endif
@endsection
