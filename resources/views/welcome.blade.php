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
    <!-- MAIN CONTENT -->   
    <div class="main-content">
        <div class="container-fluid">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-body">
                    <div class="row">
                        <h1>Dashboard Aset Yayasan Satunama</h1>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="metric">
                                    <a href="{{ route('Asettlsn.index') }}" style="text-decoration: none; color: inherit;">
                                        <span class="icon"><i class="lnr lnr-laptop-phone"></i></span>
                                        <p>
                                            <span class="number">{{ asettlsn::count() }}</span>
                                            <span class="title">Aset Dimiliki</span>
                                        </p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <a href="{{ route('Asettlsn.index', ['katakunci' => 'Rusak']) }}" style="text-decoration: none; color: inherit;">
                                        <span class="icon"><i class="lnr lnr-trash"></i></span>
                                        <p>
                                            <span class="number">{{ asettlsn::where('kondisi', 'Rusak')->count() }}</span>
                                            <span class="title">Aset Rusak</span>
                                        </p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <a href="{{ route('approve.index', ['status' => 'Dipinjam']) }}" style="text-decoration: none; color: inherit;">
                                        <span class="icon"><i class="lnr lnr-users"></i></span>
                                        <p>
                                            <span class="number">{{ $asetdipinjam }}</span>
                                            <span class="title">Aset Dipinjam</span>
                                        </p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <a href="{{ route('approve.index', ['status' => 'Melebihi batas waktu']) }}" style="text-decoration: none; color: inherit;">
                                        <span class="icon"><i class="lnr lnr-construction"></i></span>
                                        <p>
                                            <span class="number">{{ $asetbelumdikembalikan }}</span>
                                            <span class="title">Pinjaman Melebihi Batas Waktu</span>
                                        </p>
                                    </a>
                                </div>
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
                                        <tr style="cursor: pointer;" onclick="window.location='{{ route('approve.show', $peminjaman->id_peminjaman) }}'">
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
                                                    $peminjaman->status == 'Melebihi batas waktu' ? 'melebihibataswaktu' : ''
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
                            <a href="{{ route('Asettlsn.index') }}" style="text-decoration: none;">
                                <div id="pie-chart"></div>
                            </a>
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
            <h1> Dashboard Aset Yayasan Satunama</h1>
            <div class="panel panel-headline">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="metric">
                                <a href="{{ route('peminjaman.user', ['status' => 'Pending']) }}" style="text-decoration: none; color: inherit;">
                                    <span class="icon"><i class="lnr lnr-file-empty"></i></span>
                                    <p>
                                        <span class="number">{{ $jumlahPending }}</span>
                                        <span class="title">Permohonan peminjaman</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <a href="{{ route('peminjaman.user', ['status' => 'Disetujui']) }}" style="text-decoration: none; color: inherit;">
                                    <span class="icon"><i class="lnr lnr-checkmark-circle"></i></span>
                                    <p>
                                        <span class="number">{{$jumlahDisetujui }}</span>
                                        <span class="title">Peminjaman disetujui</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <a href="{{ route('peminjaman.user', ['status' => 'Dipinjam']) }}" style="text-decoration: none; color: inherit;">
                                    <span class="icon"><i class="lnr lnr-cart"></i></span>
                                    <p>
                                        <span class="number">{{ $jumlahDipinjam }}</span>
                                        <span class="title">Dipinjam</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric">
                                <a href="{{ route('peminjaman.user', ['status' => 'Melebihi batas waktu']) }}" style="text-decoration: none; color: inherit;">
                                    <span class="icon"><i class="lnr lnr-construction"></i></span>
                                    <p>
                                        <span class="number">{{ $jumlahMelebihibataswaktu }}</span>
                                        <span class="title">Melebihi batas waktu</span>
                                    </p>
                                </a>
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
                                <th>Nama</th>
                                <th>Aset Yang Dipinjam</th>
                                <th>Tanggal &amp; Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentPeminjaman as $peminjaman)
                            <tr style="cursor: pointer;" onclick="window.location='{{ route('peminjaman.userShow', ['id' => $peminjaman->id_peminjaman]) }}'">
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
                                            $peminjaman->status == 'Melebihi batas waktu' ? 'melebihibataswaktu' : ''
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
                        <div class="col-md-12 text-right"><a href="/peminjamansaya" class="btn btn-success">Lihat Semua Peminjaman</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- END MAIN -->
@endif
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
    
    .label-ditolak{
        background-color: #ff0000; /* Warna merah */
        color: #fff; /* Warna teks */
    }
    .label-melebihibataswaktu {
        background-color: #000000; /* Warna hitam */
        color: #fff; /* Warna teks */
    }
</style>
@endsection
