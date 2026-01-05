<?php

namespace App\Http\Controllers; // Dipindah ke namespace umum

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Ambil Data & Konfigurasi
        $serverKey = config('services.midtrans.server_key'); // Ambil dari config/services.php
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;

        // 2. Verifikasi Signature Key (Wajib demi Keamanan)
        $hashed = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($hashed !== $signatureKey) {
            Log::error("Peringatan: Signature Key tidak valid untuk Order ID: $orderId");
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 3. Cari Record Pembayaran
        $pembayaran = Pembayaran::where('no_invoice', $orderId)->first();

        if (!$pembayaran) {
            Log::error("Pembayaran tidak ditemukan untuk Order ID: $orderId");
            return response()->json(['message' => 'Payment record not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $pendaftaran = Pendaftaran::find($pembayaran->id_pendaftaran);

        // 4. Proses Status Transaksi
        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {

            // A. Update Tabel Pembayaran
            $pembayaran->update([
                'status_pembayaran' => 'lunas',
                'tanggal_verifikasi' => now(),
                'keterangan' => 'Lunas otomatis via Midtrans (' . $request->payment_type . ')'
            ]);

            // B. Update Tabel Pendaftaran (Sesuai Termin)
            if ($pendaftaran) {
                if (str_contains($orderId, '-T1')) {
                    // Termin 1: Klien bisa mulai upload dokumen
                    $pendaftaran->update(['status_pendaftaran' => 'bayar']);
                }
                elseif (str_contains($orderId, '-T2')) {
                    // Termin 2: Seluruh proses selesai
                    $pendaftaran->update(['status_pendaftaran' => 'selesai']);
                }
            }

            Log::info("Pembayaran Berhasil untuk Order ID: $orderId");

        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {

            $pembayaran->update(['status_pembayaran' => 'gagal']);
            Log::warning("Pembayaran Gagal/Batal untuk Order ID: $orderId - Status: $transactionStatus");
        }

        return response()->json(['status' => 'success']);
    }
}
