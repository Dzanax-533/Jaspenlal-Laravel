<?php

namespace Database\Seeders;

use App\Models\Konsultan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// Gunakan Transaction agar data aman jika terjadi error
        DB::transaction(function () {

            // 1. Buat Akun Admin
            User::create([
                'username' => 'admin_pusat',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Administrator Sistem',
                'no_telepon' => '08111111111',
                'role' => 'admin',
            ]);

            // 2. Buat Akun Bagian Keuangan
            User::create([
                'username' => 'keuangan_halal',
                'email' => 'keuangan@test.com',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Bagian Keuangan',
                'no_telepon' => '08222222222',
                'role' => 'keuangan',
            ]);

            // 3. Buat Akun Konsultan
            $userKonsultan = User::create([
                'username' => 'konsultan_halal',
                'email' => 'konsultan@test.com',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Prima Sukmana Resma',
                'no_telepon' => '08333333333',
                'role' => 'konsultan',
            ]);

            // Karena role konsultan butuh data profil tambahan di tabel konsultan
            Konsultan::create([
                'user_id' => $userKonsultan->id,
                'no_sertifikat' => 'CERT/HALAL/2025/001',
                'spesialisasi' => 'Makanan dan Minuman',
                'status' => 'aktif',
                'keterangan' => 'Konsultan Senior Spesialis Produk Olahan',
            ]);
        });
    }
}
