<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\DokumenPersyaratan;
use App\Models\Pendaftaran;
use App\Models\PaketPendampingan;
use App\Models\Klien;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan riwayat pendaftaran milik klien
     */
    public function index()
    {
        $pendaftarans = Pendaftaran::with(['paket', 'pembayaran'])
            ->where('id_klien', Auth::user()->klien->id_klien)
            ->latest()
            ->get();

        return view('klien.pendaftaran.index', compact('pendaftarans'));
    }

    /**
     * Menampilkan daftar paket untuk dipilih klien
     */
    public function listPaket()
    {
        $pakets = PaketPendampingan::where('status', 'aktif')->get();
        return view('klien.pendaftaran.daftar', compact('pakets'));
    }

    /**
     * Membuka form pendaftaran berdasarkan paket yang dipilih
     */
    public function create($id)
    {
        $paket = PaketPendampingan::findOrFail($id);
        $biaya = \App\Models\PengaturanBiaya::pluck('value', 'key');

        return view('klien.pendaftaran.create', compact('paket', 'biaya'));
    }

    /**
     * Menyimpan data pendaftaran baru & Langsung arahkan ke Checkout Termin 1
     */
    public function store(Request $request)
    {
        $paket = PaketPendampingan::findOrFail($request->id_paket);

        $request->validate([
            'id_paket' => 'required',
            'total_biaya_hidden' => 'required|numeric|min:0',
            'menu_tambahan' => 'nullable|numeric|min:0',
            'outlet_tambahan' => 'nullable|numeric|min:0',
            'lokasi' => 'required',
            'catatan' => 'required',
        ]);

        $klien = Auth::user()->klien;

        // Gunakan total_biaya dari input hidden hasil kalkulasi JS di layar
        $totalFinal = $request->total_biaya_hidden;

        $pendaftaran = Pendaftaran::create([
            'id_klien'            => $klien->id_klien,
            'id_paket'            => $request->id_paket,
            'no_pendaftaran'      => 'REG-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4)),
            'tanggal_pendaftaran' => now(),
            'status_pendaftaran'  => 'pending',
            'skala_usaha'         => $request->skala_usaha ?? $paket->skala_usaha,
            'jumlah_menu'         => $request->menu_tambahan ?? 0,
            'jumlah_outlet'       => $request->outlet_tambahan ?? 0,
            'total_biaya'         => $totalFinal,
            'catatan'             => "Lokasi: " . strtoupper($request->lokasi) . " | Alamat: " . $request->catatan,
        ]);

        return redirect()->route('klien.pembayaran.form', $pendaftaran->id_pendaftaran)
            ->with('success', 'Pendaftaran berhasil! Silakan selesaikan pembayaran DP.');
    }

    /**
     * Menampilkan detail pendaftaran & Dokumen (Hanya jika Termin 1 Lunas)
     */
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['paket', 'dokumen', 'pembayaran', 'konsultan'])
            ->where('id_pendaftaran', $id)
            ->firstOrFail();

        // LOGIKA KEAMANAN: Cek apakah sudah lunas Termin 1 (DP)
        $pembayaran = $pendaftaran->pembayaran;
        $isDpLunas = $pembayaran &&
                     $pembayaran->status_pembayaran == 'lunas' &&
                     str_contains($pembayaran->no_invoice, '-T1');

        if (!$isDpLunas) {
            return redirect()->route('klien.dashboard')
                ->with('error', 'Akses ditolak. Silakan selesaikan pembayaran DP terlebih dahulu.');
        }

        return view('klien.pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Proses Upload Dokumen ke Folder klien/dokumen/
     */
    public function uploadDokumen(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'nama_dokumen'   => 'required|string',
            'file_dokumen'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            $pendaftaran = Pendaftaran::findOrFail($request->id_pendaftaran);
            $file = $request->file('file_dokumen');

            // Penamaan file: Nama_Dokumen_IDPendaftaran_Timestamp.ext
            $cleanDocName = str_replace([' ', '/', '\\'], '_', $request->nama_dokumen);
            $fileName = $cleanDocName . '_ID' . $pendaftaran->id_pendaftaran . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan ke storage/app/public/klien/dokumen/
            $path = $file->storeAs('klien/dokumen', $fileName, 'public');

            // Update atau buat baru di tabel DokumenPersyaratan
            DokumenPersyaratan::updateOrCreate(
                [
                    'id_pendaftaran' => $request->id_pendaftaran,
                    'nama_dokumen'   => $request->nama_dokumen,
                ],
                [
                    'file_path'       => $path,
                    'status_validasi' => 'menunggu',
                    'tanggal_upload'  => now(),
                ]
            );

            return back()->with('success', 'Dokumen ' . $request->nama_dokumen . ' berhasil diunggah.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }
}
