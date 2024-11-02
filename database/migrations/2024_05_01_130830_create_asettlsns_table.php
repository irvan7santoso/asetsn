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
        Schema::create('asettlsn', function (Blueprint $table) {
            $table->id('id')->unique();
            $table->string('namabarang');
            $table->year('tahun')->nullable();
            $table->integer('jumlah');
            $table->integer('jumlah_tersedia')->nullable();
            $table->string('nomorinventaris')->nullable();
            $table->string('nomorseri')->nullable();
            $table->decimal('harga', 15,2)->nullable();
            $table->string('lokasi')->nullable();
            $table->string('pemakai')->nullable();
            $table->string('kondisi');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asettlsn');
    }
};
