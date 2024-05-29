@extends('layouts.main')

@section('container')
<div class="main-content">
    @include('layouts.alert')
        <div class="container-fluid">
            <!-- TABLE HOVER -->
            <div class="panel">
            <div class="panel-body">
              <h1>Peminjaman Aset Yayasan Satunama</h1>
              <form class="search-left" action="{{ url('peminjaman') }}" method="get">
                <div class="input-group">
                  <input type="search" class="form-control" name='katakunci' value="{{ Request::get('katakunci') }}" placeholder="Cari Aset/Alat">
                  <span class="input-group-btn"><button type="submit" class="btn btn-success">Cari</button></span>
                </div>
              </form>
              <form action="/peminjaman/create" method="GET">
            <table class="table table-hover">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>Nama Aset</th>
                    <th>Tahun</th>
                    <th>Nomor Inventaris</th>
                    <th>Nomor Seri</th>
                    <th>Jumlah Tersedia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                <tr>
                    <td><input type="checkbox" name="pinjam_barang[]" value="{{ $asset->id }}"></td>
                    <td>{{ $asset->namabarang }}</td>
                    <td>{{ $asset->tahun }}</td>
                    <td>{{ $asset->nomorinventaris }}</td>
                    <td>{{ $asset->nomorseri }}</td>
                    <td>{{ $asset->jumlah }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <button type="submit" class="btn btn-success">Pinjam Aset</button>
        </div>
    </form>
</div>

<style>
.search-left{
  float:  left !important;
}
</style>
@endsection
