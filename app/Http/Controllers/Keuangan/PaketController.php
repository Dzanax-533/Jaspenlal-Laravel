<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\PaketPendampingan;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = PaketPendampingan::all();
        return view('keuangan.paket.index', compact('pakets'));
    }

    public function edit($id)
    {
        // Mencari berdasarkan id_paket
        $paket = PaketPendampingan::findOrFail($id);
        return view('keuangan.paket.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required',
            'harga' => 'required|numeric',
            'durasi_hari' => 'required|numeric',
        ]);

        $paket = PaketPendampingan::findOrFail($id);
        $paket->update($request->all());

        return redirect()->route('keuangan.paket.index')
                         ->with('success', 'Paket berhasil diperbarui');
    }
}