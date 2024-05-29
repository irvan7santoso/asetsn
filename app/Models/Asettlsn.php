<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asettlsn extends Model
{
    use HasFactory;
    protected $fillable = ['namabarang','tahun','jumlah','nomorinventaris','nomorseri','harga','lokasi','pemakai','kondisi'];
    protected $table = 'asettlsn';
    public $timestamps = false;

    public function peminjamans()
    {
        return $this->belongsToMany(Peminjaman::class, 'item_peminjaman')->withPivot('jumlah_dipinjam')->withTimestamps();
    }

    public function reduceStock($amount)
    {
        $this->jumlah -= $amount;
        $this->save();
    }

    public function increaseStock($amount)
    {
        $this->jumlah += $amount;
        $this->save();
    }

}
