<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\PengaturanBiaya;
use Illuminate\Http\Request;

class PengaturanBiayaController extends Controller
{
    public function index()
    {
        // Mengambil semua data pengaturan biaya
        $pengaturan_biaya = PengaturanBiaya::all();
        return view('keuangan.pengaturan.index', compact('pengaturan_biaya'));
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'biaya' => 'required|array',
            'biaya.*' => 'required|numeric|min:0',
        ]);

        // Looping untuk update setiap key berdasarkan input
        foreach ($request->biaya as $key => $value) {
            PengaturanBiaya::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Daftar harga berhasil diperbarui!');
    }
}
