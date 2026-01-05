<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan riwayat pendaftaran yang pembayarannya sudah diproses sistem.
     */
    public function index()
    {
        // Mengambil pendaftaran yang sudah memiliki data pembayaran otomatis dari Midtrans
        // Kita hanya menampilkan yang statusnya 'lunas' atau 'gagal' agar Keuangan fokus pada riwayat transaksi
        $pendaftarans = Pendaftaran::with(['klien', 'paket', 'pembayaran'])
            ->whereHas('pembayaran')
            ->latest()
            ->get();

        return view('keuangan.pendaftaran.index', compact('pendaftarans'));
    }

    /**
     * Menampilkan detail pendaftaran dan rincian transaksi Midtrans.
     */
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['klien', 'paket', 'pembayaran'])->findOrFail($id);
        return view('keuangan.pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Fungsi Verifikasi Manual DIHAPUS karena digantikan oleh Webhook Midtrans.
     * Staf Keuangan kini hanya memantau laporan.
     */

    /**
     * Update biaya tetap dipertahankan jika sewaktu-waktu ada penyesuaian harga
     * SEBELUM klien melakukan pembayaran di Midtrans.
     */
    public function update_biaya(Request $request, $id)
    {
        $request->validate([
            'total_biaya' => 'required|numeric|min:0',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);

        // Proteksi: Biaya tidak boleh diubah jika sudah lunas
        if ($pendaftaran->pembayaran && $pendaftaran->pembayaran->status_pembayaran == 'lunas') {
            return back()->with('error', 'Biaya tidak dapat diubah karena status sudah lunas.');
        }

        $pendaftaran->total_biaya = $request->total_biaya;
        $pendaftaran->save();

        return redirect()->route('keuangan.pendaftaran.show', $id)->with('success', 'Total biaya berhasil diperbarui.');
    }
}
