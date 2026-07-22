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
    Schema::create('buku', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('kelas_id');
        $table->string('judul');
        $table->string('pengarang');
        $table->string('penerbit');
        $table->integer('jumlah');
        $table->year('tahun');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
