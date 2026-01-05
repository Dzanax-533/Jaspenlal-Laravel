<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ganti 'pakets' menjadi 'paket_pendampingan'
        Schema::table('paket_pendampingan', function (Blueprint $table) {
            $table->boolean('is_termin')->default(false)->after('harga');
            $table->integer('dp_persen')->default(100)->after('is_termin');
        });
    }

    public function down(): void
    {
        Schema::table('paket_pendampingan', function (Blueprint $table) {
            $table->dropColumn(['is_termin', 'dp_persen']);
        });
    }
};
