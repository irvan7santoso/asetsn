<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'id_user', 'nama_peminjam', 'nomor_hp_peminjam', 'email_peminjam', 'program',
        'judul_kegiatan', 'lokasi_kegiatan', 'tgl_peminjaman',
        'tgl_kembali', 'lampiran', 'catatan', 'status'
    ];

    public function asettlsns()
    {
        return $this->belongsToMany(Asettlsn::class, 'item_peminjaman','id_peminjaman','id_aset')->withPivot('jumlah_dipinjam')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); 
    }
}
