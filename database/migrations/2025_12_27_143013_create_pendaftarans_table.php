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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            // Menghubungkan ke id_klien di tabel klien
            $table->foreignId('id_klien')->constrained('klien', 'id_klien')->onDelete('cascade');
            // Menghubungkan ke id_paket di tabel paket_pendampingan
            $table->foreignId('id_paket')->constrained('paket_pendampingan', 'id_paket')->onDelete('cascade');
            // Menghubungkan ke id_konsultan di tabel konsultan
            $table->foreignId('id_konsultan')->constrained('konsultan', 'id_konsultan')->onDelete('cascade');

            $table->string('no_pendaftaran')->unique();
            $table->dateTime('tanggal_pendaftaran');
            $table->enum('status_pendaftaran', ['pending', 'diproses', 'selesai', 'dibatalkan']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
