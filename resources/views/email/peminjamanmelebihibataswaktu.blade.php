<!DOCTYPE html>
<html>
<head>
    <title>Pemberitahuan Peminjaman Melebihi Batas Waktu</title>
</head>
<body>
    <h1>Pemberitahuan Peminjaman Melebihi Batas Waktu</h1>
    
    @if($isAdmin)
        <p>Peminjaman oleh {{ $peminjaman->nama_peminjam }} untuk program {{ $peminjaman->program }} telah melebihi batas waktu.</p>
    @else
        <p>Peminjaman anda untuk program {{ $peminjaman->program }} telah melebihi batas waktu.</p>
    @endif    
    <!-- Menampilkan tautan -->
    <p>
        @if($isAdmin)
            <a href="{{ $url }}">Detail Peminjaman</a>
        @else
            <a href="{{ $url }}">Detail Peminjaman</a>
        @endif
    </p>
</body>
</html>
