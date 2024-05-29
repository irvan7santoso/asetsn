@extends('layouts.main')

@section('container')
<form action='{{ url('Asettlsn') }}' method="POST">
@csrf
<div class="main-content">
    @include('layouts.alert')
    <div class="container-fluid">
        <h1>Tambah Aset/Peralatan Baru</h1>
        <div class="panel">
            <div class="panel-body">
                <h4>Nama Aset/Alat</h4>
                <input type="text" class="form-control" name='namabarang' value="{{ Session::get ('namabarang') }}" id='namabarang'>
                <h4>Tahun</h4>
                <input type="text" class="form-control" name='tahun' value="{{ Session::get ('tahun') }}" id='tahun'>
                <h4>Jumlah</h4>
                <input type="text" class="form-control" name='jumlah' value="{{ Session::get ('jumlah') }}" id='jumlah'>
                <h4>Nomor Inventaris</h4>
                <input type="text" class="form-control" name='nomorinventaris' value="{{ Session::get ('nomorinventaris') }}" id="nomorinventaris">
                <h4>Nomor Seri</h4>
                <input type="text" class="form-control" name='nomorseri' value="{{ Session::get ('nomorseri') }}" id='nomorseri'>
                <h4>Harga</h4>
                <input type="text" class="form-control" name='harga' value="{{ Session::get ('harga') }}" id='harga'>
                <h4>Lokasi</h4>
                <input type="text" class="form-control" name='lokasi' value="{{ Session::get ('lokasi') }}" id='lokasi'>
                <h4>Kondisi</h4>
                <select class="form-control" name="kondisi" id="kondisi">
                    <option value="Baik" {{ Session::get('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Sedang" {{ Session::get('kondisi') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Rusak" {{ Session::get('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>                
            </div>
            <div class="panel-footer">
                    <div class="text-right">
                        <a href="{{ url('Asettlsn') }}"  class="btn btn-danger" >Batal</a>
                        <button type="submit" class="btn btn-success" name="submit" >Submit</button>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

