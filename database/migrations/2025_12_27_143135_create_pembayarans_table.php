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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_pendaftaran')->constrained('pendaftaran', 'id_pendaftaran')->onDelete('cascade');

            $table->string('no_invoice')->unique();
            $table->decimal('jumlah_pembayaran', 15, 2);
            $table->dateTime('tanggal_pembayaran');
            $table->enum('metode_pembayaran', ['transfer', 'cash', 'ewallet']);
            $table->string('bukti_pembayaran');
            $table->enum('status_pembayaran', ['pending', 'lunas', 'gagal']);

            // Siapa admin/keuangan yang memverifikasi? Merujuk ke tabel users
            $table->foreignId('verified_by')->nullable()->constrained('users', 'id');
            $table->dateTime('tanggal_verifikasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
