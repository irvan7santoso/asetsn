@extends('layouts.main')

@section('container')
<div class="main-content">
    <form action='{{ url('Asettlsn/'. $data->id) }}' method="POST">
    @csrf
    @method('put')
    <div class="container-fluid">
        <div class="panel">
            <div class="panel-body">
                <h1>Edit Aset / Peralatan : {{ $data->namabarang }}</h1>
                <h4>Tahun</h4>
                <input type="text" class="form-control" name='tahun' value="{{ $data->tahun }}" id="tahun">
                <h4>Jumlah</h4>
                <input type="text" class="form-control" name='jumlah' value="{{ $data->jumlah }}" id="jumlah">
                <h4>Nomor Inventaris</h4>
                <input type="text" class="form-control" name='nomorinventaris' value="{{ $data->nomorinventaris }}" id="nomorinventaris">
                <h4>Nomor Seri</h4>
                <input type="text" class="form-control" name='nomorseri' value="{{ $data->nomorseri }}" id="nomorseri">
                <h4>Harga</h4>
                <input type="text" class="form-control" name='harga' value="{{ $data->harga }}" id="harga">
                <h4>Lokasi</h4>
                <input type="text" class="form-control" name='lokasi' value="{{ $data->lokasi }}" id="lokasi">
                <h4>Kondisi</h4>
                <select class="form-control" name="kondisi" id="kondisi">
                    <option value="Baik" {{ $data->kondisi === 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Sedang" {{ $data->kondisi === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Rusak" {{ $data->kondisi === 'Rusak' ? 'selected' : '' }}>Rusak</option>
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