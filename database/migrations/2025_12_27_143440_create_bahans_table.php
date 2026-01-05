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
        Schema::create('bahan', function (Blueprint $table) {
            $table->id('id_bahan');
            $table->foreignId('id_pendaftaran')->constrained('pendaftaran', 'id_pendaftaran')->onDelete('cascade');
            $table->string('nama_bahan');
            $table->string('jenis_bahan');
            $table->string('asal_bahan');
            $table->string('supplier');
            $table->string('no_sertifikat_halal_bahan');
            $table->enum('status_halal', ['halal', 'tidak_halal', 'pending']);
            $table->text('keterangan')->nullable();
            $table->timestamps(); // ERD asal: datetime created_at, kita gunakan standar Laravel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan');
    }
};
