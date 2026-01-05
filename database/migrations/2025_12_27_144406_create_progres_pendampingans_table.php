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
        Schema::create('progres_pendampingan', function (Blueprint $table) {
            $table->id('id_progres');
            $table->foreignId('id_pendaftaran')->constrained('pendaftaran', 'id_pendaftaran')->onDelete('cascade');
            $table->string('tahap_progres');
            $table->text('deskripsi_progres');
            $table->integer('persentase_selesai');
            $table->dateTime('tanggal_progres');
            $table->foreignId('updated_by')->constrained('users', 'id');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_pendampingan');
    }
};
