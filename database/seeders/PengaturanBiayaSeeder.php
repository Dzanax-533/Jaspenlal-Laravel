<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanBiayaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['key' => 'harga_dasar_kecil', 'value' => 2500000, 'keterangan' => 'Harga 50 menu & 1 fasilitas'],
            ['key' => 'harga_dasar_menengah', 'value' => 10000000, 'keterangan' => 'Harga 50 menu & 1 fasilitas'],
            ['key' => 'harga_dasar_besar', 'value' => 22000000, 'keterangan' => 'Harga 50 menu & 1 fasilitas'],
            ['key' => 'tambahan_menu_kecil', 'value' => 500000, 'keterangan' => 'Tambahan per 30 menu'],
            ['key' => 'tambahan_menu_menengah', 'value' => 1000000, 'keterangan' => 'Tambahan per 30 menu'],
            ['key' => 'tambahan_menu_besar', 'value' => 1500000, 'keterangan' => 'Tambahan per 30 menu'],
            ['key' => 'biaya_fasilitas_tambahan', 'value' => 1500000, 'keterangan' => 'Harga per outlet tambahan'],
        ];

        foreach ($data as $item) {
            DB::table('pengaturan_biaya')->updateOrInsert(
                ['key' => $item['key']],
                [
                    'value' => $item['value'],
                    'keterangan' => $item['keterangan'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
