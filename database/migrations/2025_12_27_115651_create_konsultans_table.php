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
        Schema::create('konsultan', function (Blueprint $table) {
            $table->id('id_konsultan');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_sertifikat');
            $table->string('spesialisasi');
            $table->enum('status', ['aktif', 'tidak_aktif']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultan');
    }
};
