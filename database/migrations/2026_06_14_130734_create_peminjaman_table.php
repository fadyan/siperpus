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
        $table->id();
        $table->bigInteger('siswa_id');
        $table->bigInteger('buku_id');
        $table->date('tgl_pinjam');
        $table->date('tgl_rencana_kembali')->nullable();
        $table->date('tgl_kembali');
        $table->enum('status', ['dipinjam','dikembalikan'])->default('dipinjam');
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
