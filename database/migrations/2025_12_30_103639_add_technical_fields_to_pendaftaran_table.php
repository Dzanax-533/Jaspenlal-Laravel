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
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('skala_usaha')->nullable()->after('id_paket');
            $table->integer('jumlah_menu')->default(0)->after('skala_usaha');
            $table->integer('jumlah_outlet')->default(0)->after('jumlah_menu');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['skala_usaha', 'jumlah_menu', 'jumlah_outlet']);
        });
    }
};
