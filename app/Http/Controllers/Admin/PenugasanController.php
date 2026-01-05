<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    /**
     * Menampilkan daftar pendaftaran klien yang belum dan sudah punya konsultan.
     */
    public function index()
    {
        // 1. Ambil Klien yang sudah mendaftar tapi id_konsultan masih NULL
        $antrean = Pendaftaran::with(['klien', 'paket'])
                    ->whereNull('id_konsultan')
                    ->latest()
                    ->get();

        // 2. Ambil Riwayat pendaftaran yang sudah berhasil dibagikan konsultannya
        $riwayat = Pendaftaran::with(['klien', 'paket', 'konsultan'])
                    ->whereNotNull('id_konsultan')
                    ->latest()
                    ->get();

        // 3. Ambil daftar user yang rolenya 'konsultan' untuk pilihan dropdown
        $konsultans = User::where('role', 'konsultan')->get();

        return view('admin.penugasan.index', compact('antrean', 'riwayat', 'konsultans'));
    }

    /**
     * Memproses penugasan konsultan ke klien tertentu.
     */
    public function store(Request $request, $id)
    {
        // Validasi: Pastikan konsultan yang dipilih ada di tabel users
        $request->validate([
            'id_konsultan' => 'required|exists:users,id',
        ], [
            'id_konsultan.required' => 'Pilih konsultan terlebih dahulu!'
        ]);

        // Cari data pendaftarannya
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Update kolom id_konsultan
        $pendaftaran->update([
            'id_konsultan' => $request->id_konsultan,
            // Jika Anda punya kolom status di pendaftarans, bisa diubah ke 'proses'
            // 'status' => 'proses'
        ]);

        return redirect()->route('admin.penugasan.index')
            ->with('success', 'Konsultan ' . $pendaftaran->konsultan->nama_lengkap . ' berhasil ditugaskan untuk klien ' . $pendaftaran->klien->nama_lengkap);
    }
}
