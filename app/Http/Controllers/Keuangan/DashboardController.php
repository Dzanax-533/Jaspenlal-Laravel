<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendapatan = Pendaftaran::sum('total_biaya');
        $pendaftaranPending = Pendaftaran::where('status_pendaftaran', 'pending')->count();
        $pendaftaranSelesai = Pendaftaran::where('status_pendaftaran', 'selesai')->count();

        $recentPendaftarans = Pendaftaran::with(['klien', 'paket'])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        return view('keuangan.dashboard', compact(
            'totalPendapatan',
            'pendaftaranPending',
            'pendaftaranSelesai',
            'recentPendaftarans'
        ));
    }
}
