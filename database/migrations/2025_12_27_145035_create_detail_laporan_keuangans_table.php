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
        Schema::create('detail_laporan_keuangan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_laporan')->constrained('laporan_keuangan', 'id_laporan')->onDelete('cascade');
            $table->foreignId('id_pembayaran')->constrained('pembayaran', 'id_pembayaran');
            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran']);
            $table->decimal('jumlah', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_laporan_keuangan');
    }
};
