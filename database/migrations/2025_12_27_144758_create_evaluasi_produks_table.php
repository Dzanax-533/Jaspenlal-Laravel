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
        Schema::create('evaluasi_produk', function (Blueprint $table) {
            $table->id('id_evaluasi');
            $table->foreignId('id_pendaftaran')->constrained('pendaftaran', 'id_pendaftaran')->onDelete('cascade');
            $table->foreignId('id_konsultan')->constrained('konsultan', 'id_konsultan');
            $table->text('hasil_evaluasi');
            $table->text('rekomendasi');
            $table->enum('status_evaluasi', ['lolos', 'tidak_lolos', 'perlu_perbaikan']);
            $table->dateTime('tanggal_evaluasi');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_produk');
    }
};
