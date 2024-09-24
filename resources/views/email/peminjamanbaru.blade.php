<!DOCTYPE html>
<html>
<head>
    <title>Permohonan Peminjaman Baru</title>
</head>
<body>
    <h1>Permohonan Peminjaman Baru</h1>
    <p>Ada permohonan peminjaman baru oleh {{ $nama_peminjam }} untuk program {{ $program }}.</p>
    <p><strong>Tanggal Peminjaman:</strong> {{ $tgl_peminjaman }}</p>
    <p><strong>Tanggal Kembali:</strong> {{ $tgl_kembali }}</p>
    <a href="{{ $url }}">Lihat Detail Peminjaman</a>
</body>
</html>
