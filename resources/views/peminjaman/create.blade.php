@extends('layouts.main')

@section('container')
<div class="main-content">
    @include('layouts.alert')
    <div class="container-fluid">
        <div class="panel">
            <div class="panel-body">
                <h1>Form Peminjaman Aset</h1>
                <form id="peminjamanForm" action="/peminjaman/create" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Jenis Peminjam</label>
                        <div class="radio-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_peminjam" id="karyawan" value="karyawan" checked required>
                                <label class="form-check-label" for="karyawan">Karyawan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_peminjam" id="non_karyawan" value="non_karyawan" required>
                                <label class="form-check-label" for="non_karyawan">Non Karyawan</label>
                            </div>
                        </div>
                    </div>
                    <div id="form_peminjam">
                        <!-- Form Karyawan -->
                        <div id="form_karyawan">
                            <div class="form-group">
                                <label for="nama_karyawan">Nama Peminjam</label>
                                <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nomor_hp_karyawan">Nomor HP</label>
                                <input type="text" class="form-control" id="nomor_hp_karyawan" name="nomor_hp_karyawan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="email_karyawan">Email</label>
                                <input type="email" class="form-control" id="email_karyawan" name="email_karyawan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="program">Program</label>
                                <select class="form-control" id="program" name="program" required>
                                    <option value="">Pilih Program</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->nama_program }}" data-judul="{{ $program->judul_kegiatan }}" data-lokasi="{{ $program->lokasi_kegiatan }}">
                                            {{ $program->nama_program }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="judul_kegiatan">Judul Kegiatan</label>
                                <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="lokasi_kegiatan">Lokasi Kegiatan</label>
                                <input type="text" class="form-control" id="lokasi_kegiatan" name="lokasi_kegiatan" readonly>
                            </div>
                        </div>
                        <!-- Form Non Karyawan -->
                        <div id="form_non_karyawan" style="display: none;">
                            <div class="form-group">
                                <label for="nama_peminjam">Nama Peminjam</label>
                                <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                            </div>
                            <div class="form-group">
                                <label for="nomor_hp_peminjam">Nomor HP</label>
                                <input type="text" class="form-control" id="nomor_hp_peminjam" name="nomor_hp_peminjam" required>
                            </div>
                            <div class="form-group">
                                <label for="email_peminjam">Email</label>
                                <input type="email" class="form-control" id="email_peminjam" name="email_peminjam" required>
                            </div>
                            <div class="form-group">
                                <label for="program_non_karyawan">Alasan Peminjaman</label>
                                <input type="text" class="form-control" id="program_non_karyawan" name="program_non_karyawan" required>
                            </div>
                        </div>
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
                        <input type="file" class="form-control" id="lampiran" name="lampiran" accept=".jpg,.jpeg,.png" required>
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
                                    <input type="number" name="barang[{{ $asset->id }}][jumlah_dipinjam]" class="form-control" max="{{ $asset->jumlah }}" value="{{ $asset->jumlah_dipinjam }}" required>
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
<style>
.radio-group {
    display: flex;
    flex-direction: row;
    gap: 20px;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default date to H+3
    var dateInput = document.getElementById('tgl_peminjaman');
    var returnDateInput = document.getElementById('tgl_kembali');
    var today = new Date();
    today.setDate(today.getDate() + 3);
    var day = ('0' + today.getDate()).slice(-2);
    var month = ('0' + (today.getMonth() + 1)).slice(-2);
    var year = today.getFullYear();
    dateInput.value = year + '-' + month + '-' + day;
    returnDateInput.value = year + '-' + month + '-' + day;

    document.querySelectorAll('input[name="jenis_peminjam"]').forEach((elem) => {
        elem.addEventListener('change', function() {
            var jenis = this.value;
            var formKaryawan = document.getElementById('form_karyawan');
            var formNonKaryawan = document.getElementById('form_non_karyawan');
            var namaPeminjam = document.getElementById('nama_peminjam');
            var nomorHpPeminjam = document.getElementById('nomor_hp_peminjam');
            var emailPeminjam = document.getElementById('email_peminjam');
            var program = document.getElementById('program');
            var programNonKaryawan = document.getElementById('program_non_karyawan');

            if (jenis === 'karyawan') {
                formKaryawan.style.display = 'block';
                formNonKaryawan.style.display = 'none';
                
                program.setAttribute('required', 'required');
                programNonKaryawan.removeAttribute('required');
                namaPeminjam.removeAttribute('required');
                nomorHpPeminjam.removeAttribute('required');
                emailPeminjam.removeAttribute('required');

                fetch('/api/user-info')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('nama_karyawan').value = data.nama;
                        document.getElementById('nomor_hp_karyawan').value = data.nomor_hp;
                        document.getElementById('email_karyawan').value = data.email;  // Isi email karyawan
                    });
            } else {
                formKaryawan.style.display = 'none';
                formNonKaryawan.style.display = 'block';

                namaPeminjam.setAttribute('required', 'required');
                nomorHpPeminjam.setAttribute('required', 'required');
                emailPeminjam.setAttribute('required', 'required');
                program.removeAttribute('required');
                programNonKaryawan.setAttribute('required', 'required');

                // Clear the Karyawan fields when switching to Non Karyawan
                document.getElementById('nama_karyawan').value = '';
                document.getElementById('nomor_hp_karyawan').value = '';
                document.getElementById('email_karyawan').value = '';
            }
        });
    });

    document.getElementById('program').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('judul_kegiatan').value = selectedOption.getAttribute('data-judul');
        document.getElementById('lokasi_kegiatan').value = selectedOption.getAttribute('data-lokasi');
    });

    // Trigger change event on page load
    document.querySelector('input[name="jenis_peminjam"]:checked').dispatchEvent(new Event('change'));
});
</script>

@endsection
