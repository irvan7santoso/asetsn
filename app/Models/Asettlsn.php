<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asettlsn extends Model
{
    use HasFactory;
    protected $fillable = ['namabarang','tahun','jumlah','jumlah_tersedia','nomorinventaris','nomorseri','harga','lokasi','pemakai','kondisi'];
    protected $table = 'asettlsn';
    public $timestamps = false;

    // Event Eloquent untuk mengisi jumlah_tersedia saat aset dibuat
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Mengisi jumlah_tersedia sama dengan jumlah jika tidak diisi
            if (is_null($model->jumlah_tersedia)) {
                $model->jumlah_tersedia = $model->jumlah;
            }
        });
    }

    public function peminjamans()
    {
        return $this->belongsToMany(Peminjaman::class, 'item_peminjaman', 'id_aset', 'id_peminjaman')
            ->withPivot('jumlah_dipinjam')
            ->withTimestamps()
            ->where('status', 'Dipinjam');
    }

    public function reduceStock($amount)
    {
        if ($this->jumlah_tersedia >= $amount) {
            $this->jumlah_tersedia -= $amount;
            $this->save();
        } else {
            throw new \Exception("Jumlah tersedia tidak cukup");
        }
    }

    public function increaseStock($amount)
    {
        if (($this->jumlah_tersedia + $amount) <= $this->jumlah) {
            $this->jumlah_tersedia += $amount;
            $this->save();
        } else {
            throw new \Exception("Jumlah tersedia melebihi jumlah aset total");
        }
    }
}
