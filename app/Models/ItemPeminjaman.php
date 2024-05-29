<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'item_peminjaman';
    protected $primaryKey = 'id_item_peminjaman';
    protected $fillable = [
        'id_peminjaman', 'id_aset', 'jumlah_dipinjam'
    ];

    public function asettlsns()
    {
        return $this->belongsTo(Asettlsn::class,'id_aset');
    }

    public function peminjamans()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
