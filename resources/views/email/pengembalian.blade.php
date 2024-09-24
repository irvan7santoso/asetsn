<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Pengembalian</title>
</head>
<body>
    <h1>Pengembalian</h1>
    <p>Peminjam: {{ $nama_peminjam }}</p>
    <p>Program: {{ $program }}</p> <!-- Tambahkan ini -->
    <p>Tanggal Peminjaman: {{ $tgl_peminjaman }}</p> <!-- Tambahkan ini -->
    <p>Tanggal Kembali: {{ $tgl_kembali }}</p> <!-- Tambahkan ini -->
    <a href="{{ $url }}">Lihat Detail</a>
</body>
</html>
