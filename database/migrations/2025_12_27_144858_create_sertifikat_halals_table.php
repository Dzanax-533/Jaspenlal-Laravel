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
        Schema::create('sertifikat_halal', function (Blueprint $table) {
            $table->id('id_sertifikat');
            $table->foreignId('id_pendaftaran')->constrained('pendaftaran', 'id_pendaftaran')->onDelete('cascade');
            $table->string('no_sertifikat')->unique();
            $table->string('file_path');
            $table->dateTime('tanggal_terbit');
            $table->dateTime('tanggal_berlaku');
            $table->dateTime('tanggal_kadaluarsa');
            $table->foreignId('uploaded_by')->constrained('users', 'id');
            $table->dateTime('tanggal_upload');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_halal');
    }
};
