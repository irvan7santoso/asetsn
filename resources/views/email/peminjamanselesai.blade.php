<!DOCTYPE html>
<html>
<head>
    <title>Peminjaman Selesai</title>
</head>
<body>
    @if($isAdmin)
        <p>Peminjaman oleh {{ $peminjaman->nama_peminjam }} untuk program {{ $peminjaman->program }} telah selesai.</p>
    @else
        <p>Peminjaman Anda untuk program {{ $peminjaman->program }} telah selesai.</p>
    @endif.
    <p>Terima kasih</p>
</body>
</html>
