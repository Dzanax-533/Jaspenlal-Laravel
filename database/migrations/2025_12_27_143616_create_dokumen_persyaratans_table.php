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
        Schema::create('dokumen_persyaratan', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->foreignId('id_pendaftaran')->constrained('pendaftaran', 'id_pendaftaran')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('jenis_dokumen');
            $table->string('file_path');
            $table->dateTime('tanggal_upload');
            $table->enum('status_validasi', ['pending', 'disetujui', 'ditolak']);
            $table->foreignId('validated_by')->nullable()->constrained('users', 'id');
            $table->dateTime('tanggal_validasi')->nullable();
            $table->text('catatan_validasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_persyaratan');
    }
};
