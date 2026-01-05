<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_klien' => User::where('role', 'klien')->count(),
            'total_konsultan' => User::where('role', 'konsultan')->count(),
            'total_keuangan' => User::where('role', 'keuangan')->count(),
        ];

        // Ambil pendaftaran yang belum memiliki konsultan (antrean pembagian)
        $antrean_pendaftaran = Pendaftaran::with(['klien', 'paket'])
                                ->whereNull('id_konsultan')
                                ->latest()
                                ->get();

        // Ambil daftar konsultan untuk dipilih oleh admin
        $konsultans = User::where('role', 'konsultan')->get();

        return view('admin.dashboard', compact('stats', 'antrean_pendaftaran', 'konsultans'));
    }

    /**
     * Method untuk memproses pilihan admin: Menghubungkan Klien dengan Konsultan
     */
    public function assignKonsultan(Request $request, $id)
    {
        $request->validate([
            'id_konsultan' => 'required|exists:users,id',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'id_konsultan' => $request->id_konsultan
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Konsultan berhasil ditugaskan!');
}
}
