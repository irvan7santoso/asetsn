@extends('layouts.main')

@section('container')
    <div class="main-content">
      @include('layouts.alert')
        <div class="container-fluid">
            <!-- TABLE HOVER -->
            <div class="panel">
            <div class="panel-body">
              <h1>Daftar Aset Yayasan Satunama</h1>
              <form class="search-left" action="{{ url('Asettlsn') }}" method="get">
                <div class="input-group">
                  <input type="search" class="form-control" name='katakunci' value="{{ Request::get('katakunci') }}" placeholder="Cari Aset/Alat">
                  <span class="input-group-btn"><button type="submit" class="btn btn-success">Cari</button></span>
                </div>
              </form>
              <div class="row">
                <div class="text-right"><a href="/Asettlsn/create" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Aset</a></div>
              </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Aset/Alat</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <th>Nomor Inventaris</th>
                            <th>Nomor Seri</th>
                            <th>Harga</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $i = $data->firstItem() ?>
                      @foreach ($data as $item)
                      <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->namabarang }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->nomorinventaris }}</td>
                        <td>{{ $item->nomorseri }}</td>
                        <td>{{ $item->harga }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ $item->kondisi }}</td>
                        <td>
                          <a href='{{ url('Asettlsn/'.$item->id.'/edit') }}' class="btn btn-warning btn-xs"><i class="lnr lnr-pencil"></i></a>
                          <form onsubmit="return confirm('Apakah anda yakin menghapus data ini?')" class='inline' action="{{ url('Asettlsn/'.$item->id) }}" style="display: inline;" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" name="submit" class="btn btn-danger btn-xs"><i class="lnr lnr-trash"></i></button>
                          </form>
                        </td>
                      </tr>
                      <?php $i++ ?>
                      @endforeach
                    </tbody>
                </table>
                {{ $data->Links() }}
            </div>
        </div>
    </div>
 </div>

 <style>
.search-left{
  float:  left !important;
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