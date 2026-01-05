<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\DokumenPersyaratan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil pendaftaran klien yang ditugaskan kepada konsultan yang login
        $klien_saya = Pendaftaran::with(['klien', 'paket'])
                        ->where('id_konsultan', Auth::id())
                        ->latest()
                        ->get();

        // Statistik sederhana untuk dashboard konsultan
        $stats = [
            'total_klien' => $klien_saya->count(),
            'perlu_verifikasi' => DokumenPersyaratan::whereIn('id_pendaftaran', $klien_saya->pluck('id'))
                                    ->where('status_validasi', 'pending')
                                    ->count()
        ];

        return view('konsultan.dashboard', compact('klien_saya', 'stats'));
    }

    public function detailKlien($id)
    {
        // Memastikan konsultan hanya bisa melihat klien miliknya
        $pendaftaran = Pendaftaran::with(['klien', 'paket', 'dokumen'])
                        ->where('id_konsultan', Auth::id())
                        ->findOrFail($id);

        return view('konsultan.detail_klien', compact('pendaftaran'));
    }
}
