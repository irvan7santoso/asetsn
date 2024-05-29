<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->foreignId('id_user')->constrained('users', 'id');
            $table->string('nama_peminjam');
            $table->string('nomor_hp_peminjam');
            $table->string('program');
            $table->string('judul_kegiatan');
            $table->string('lokasi_kegiatan');
            $table->date('tgl_peminjaman');
            $table->date('tgl_kembali');
            $table->binary('lampiran')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status',['Pending','Disetujui','Ditolak','Selesai','Melebihi batas waktu'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
