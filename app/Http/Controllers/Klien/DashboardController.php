<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Klien;
use App\Models\PaketPendampingan;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\DokumenPersyaratan; // Pastikan konsisten dengan model DokumenPersyaratan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Klien
     */
    public function index()
    {
        $user = Auth::user();
        $klien = $user->klien;

        $pakets = PaketPendampingan::where('status', 'aktif')->get();
        $pendaftaran = null;
        $dokumenPerbaikan = collect();
        $currentStep = 1;

        if ($klien) {
            $pendaftaran = Pendaftaran::with(['paket', 'pembayaran', 'dokumen'])
                            ->where('id_klien', $klien->id_klien)
                            ->latest()
                            ->first();

            if ($pendaftaran) {
                // Auto-sync status jika pembayaran Midtrans T1 sudah lunas
                if ($pendaftaran->pembayaran &&
                    $pendaftaran->pembayaran->status_pembayaran == 'lunas' &&
                    str_contains($pendaftaran->pembayaran->no_invoice, '-T1') &&
                    $pendaftaran->status_pendaftaran == 'pending') {

                    $pendaftaran->update(['status_pendaftaran' => 'bayar']);
                    $pendaftaran->refresh();
                }

                // Filter dokumen yang membutuhkan revisi
                $dokumenPerbaikan = $pendaftaran->dokumen->where('status_validasi', 'perbaikan');

                // Logika Stepper
                $statusMap = [
                    'pending' => 2,
                    'bayar'   => 3,
                    'proses'  => 4,
                    'sidang'  => 5,
                    'selesai' => 6
                ];
                $currentStep = $statusMap[$pendaftaran->status_pendaftaran] ?? 1;
            }
        }

        return view('klien.dashboard', compact('pakets', 'currentStep', 'pendaftaran', 'dokumenPerbaikan'));
    }

    /**
     * Menampilkan Daftar Pembayaran & Tagihan Termin
     */
    public function indexPembayaran()
    {
        $klien = Auth::user()->klien;
        if (!$klien) return redirect()->route('klien.dashboard');

        $pendaftarans = Pendaftaran::with(['paket', 'pembayaran', 'dokumen'])
                        ->where('id_klien', $klien->id_klien)
                        ->latest()
                        ->get();

        return view('klien.pembayaran.index', compact('pendaftarans'));
    }

    /**
     * Tampilan Khusus Manajemen Dokumen (Slot-based)
     */
    public function dokumen()
    {
        $klien = Auth::user()->klien;
        if (!$klien) return redirect()->route('klien.dashboard');

        $pendaftaran = Pendaftaran::with('dokumen')
                        ->where('id_klien', $klien->id_klien)
                        ->latest()
                        ->first();

        if (!$pendaftaran) {
            return redirect()->route('klien.dashboard')->with('error', 'Silakan daftar paket terlebih dahulu.');
        }

        // Keamanan: Menu upload terbuka jika Pembayaran Termin 1 (DP) Lunas
        $pembayaran = $pendaftaran->pembayaran;
        $isDpLunas = $pembayaran &&
                     $pembayaran->status_pembayaran == 'lunas' &&
                     str_contains($pembayaran->no_invoice, '-T1');

        if (!$isDpLunas) {
            return redirect()->route('klien.dashboard')->with('error', 'Akses unggah dokumen terkunci. Silakan selesaikan pembayaran DP (Termin 1) terlebih dahulu.');
        }

        return view('klien.dokumen.index', compact('pendaftaran'));
    }

    /**
     * Proses Simpan Dokumen
     */
    public function storeDokumen(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'nama_dokumen'   => 'required|string',
            'file_dokumen'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('file_dokumen');
        $cleanName = str_replace([' ', '/', '\\'], '_', $request->nama_dokumen);
        $fileName = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('klien/dokumen', $fileName, 'public');

        DokumenPersyaratan::updateOrCreate(
            ['id_pendaftaran' => $request->id_pendaftaran, 'nama_dokumen' => $request->nama_dokumen],
            [
                'file_path' => $path,
                'status_validasi' => 'menunggu',
                'tanggal_upload' => now()
            ]
        );

        return back()->with('success', 'Dokumen ' . $request->nama_dokumen . ' berhasil diunggah.');
    }

    /**
     * Integrasi Midtrans 2 Termin (50/50)
     */
    public function formPembayaran($id)
    {
        // Eager loading untuk mencegah error property on null di View
        $pendaftaran = Pendaftaran::with(['paket', 'klien.user', 'pembayaran'])->findOrFail($id);

        // 1. Validasi Total Biaya (Gunakan total_biaya dari DB, hitung ulang hanya jika nol)
        $totalTagihanReal = (int) $pendaftaran->total_biaya;
        if ($totalTagihanReal <= 0) {
            $tarifPer30 = ($pendaftaran->skala_usaha === 'kecil') ? 500000 :
                        (($pendaftaran->skala_usaha === 'menengah') ? 1000000 : 1500000);

            $totalTagihanReal = (int) $pendaftaran->paket->harga +
                            (ceil($pendaftaran->jumlah_menu / 30) * $tarifPer30) +
                            ($pendaftaran->jumlah_outlet * 1500000);

            $pendaftaran->update(['total_biaya' => $totalTagihanReal]);
        }

        // 2. Logika Penentuan Termin
        $pembayaranLama = $pendaftaran->pembayaran;
        $isTermin1Lunas = ($pembayaranLama &&
                        $pembayaranLama->status_pembayaran == 'lunas' &&
                        str_contains($pembayaranLama->no_invoice, '-T1'));

        $amountToPay = $totalTagihanReal / 2;
        $orderIdSuffix = $isTermin1Lunas ? '-T2' : '-T1';
        $itemName = ($isTermin1Lunas ? 'Pelunasan (50%) - ' : 'DP (50%) - ') . $pendaftaran->paket->nama_paket;

        // 3. Integrasi Midtrans
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $auth = base64_encode($serverKey . ':');
        $url = config('app.env') == 'production'
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $payload = [
            'transaction_details' => [
                'order_id' => 'INV-' . $pendaftaran->id_pendaftaran . '-' . time() . $orderIdSuffix,
                'gross_amount' => (int) $amountToPay,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->nama_lengkap ?? $pendaftaran->klien->user->nama_lengkap,
                'email' => Auth::user()->email ?? $pendaftaran->klien->user->email,
            ],
            'item_details' => [[
                'id' => $pendaftaran->paket->id_paket . $orderIdSuffix,
                'price' => (int) $amountToPay,
                'quantity' => 1,
                'name' => substr($itemName, 0, 50)
            ]]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ])->withOptions(['verify' => false])->post($url, $payload);

            if ($response->successful()) {
                $snapToken = $response->json()['token'];

                // Simpan record pembayaran sebagai 'pending'
                Pembayaran::updateOrCreate(
                    ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
                    [
                        'no_invoice' => $payload['transaction_details']['order_id'],
                        'jumlah_pembayaran' => $payload['transaction_details']['gross_amount'],
                        'status_pembayaran' => 'pending',
                        'tanggal_pembayaran' => now(),
                        'metode_pembayaran' => 'midtrans_termin',
                    ]
                );

                // REFRESH DATA RELASI: Sangat penting agar View tidak membaca pembayaran sebagai null
                $pendaftaran->load('pembayaran');

                return view('klien.pembayaran.form', compact('pendaftaran', 'snapToken'));
            }
            return back()->with('error', 'Midtrans Error: ' . $response->body());
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan Sistem: ' . $e->getMessage());
        }
    }

    /**
     * Manajemen Bahan
     */
    public function bahan()
    {
        $klien = Auth::user()->klien;
        if (!$klien) return redirect()->route('klien.dashboard');

        $pendaftaran = Pendaftaran::where('id_klien', $klien->id_klien)->latest()->first();
        if (!$pendaftaran) return redirect()->route('klien.dashboard')->with('error', 'Silakan daftar paket terlebih dahulu.');

        $bahans = Bahan::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->get();
        return view('klien.bahan.index', compact('bahans', 'pendaftaran'));
    }

    public function storeBahan(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'nama_bahan'     => 'required|string|max:255',
            'produsen'       => 'required|string|max:255',
        ]);

        Bahan::create($request->all());
        return back()->with('success', 'Data bahan berhasil ditambahkan.');
    }

    public function hapusBahan($id)
    {
        Bahan::findOrFail($id)->delete();
        return back()->with('success', 'Data bahan berhasil dihapus.');
    }
}
