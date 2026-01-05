<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $notification = json_decode($request->getContent(), true);

        // Verifikasi Signature
        $server_key = env('MIDTRANS_SERVER_KEY');
        $signature_key = hash("sha512",
            $notification['order_id'] .
            $notification['status_code'] .
            $notification['gross_amount'] .
            $server_key
        );

        if ($signature_key !== $notification['signature_key']) {
            Log::error("Midtrans Callback: Signature Key tidak valid!");
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $paymentType = $notification['payment_type'];

        // Ambil ID Pendaftaran
        $orderParts = explode('-', $orderId);
        $id_pendaftaran = $orderParts[1] ?? null;

        if (!$id_pendaftaran) {
            return response()->json(['message' => 'Invalid Order ID Format'], 400);
        }

        $pendaftaran = Pendaftaran::find($id_pendaftaran);
        $pembayaran = Pembayaran::where('id_pendaftaran', $id_pendaftaran)->first();

        if (!$pendaftaran || !$pembayaran) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        try {
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {

                // 1. UPDATE DATA PEMBAYARAN
                $pembayaran->update([
                    'no_invoice' => $orderId, // Update dengan invoice terbaru (T1 atau T2)
                    'status_pembayaran' => 'lunas',
                    'metode_pembayaran' => $paymentType,
                    'tanggal_pembayaran' => now()
                ]);

                // 2. LOGIKA TERMIN 1 (DP)
                if (str_contains($orderId, '-T1')) {
                    $pendaftaran->update(['status_pendaftaran' => 'bayar']);
                    Log::info("DP Lunas: Pendaftaran $id_pendaftaran akses upload dibuka.");
                }

                // 3. LOGIKA TERMIN 2 (PELUNASAN)
                if (str_contains($orderId, '-T2')) {
                    $pendaftaran->update(['status_pendaftaran' => 'selesai']);
                    Log::info("Pelunasan Lunas: Pendaftaran $id_pendaftaran selesai total.");
                }

            } elseif ($transactionStatus == 'pending') {
                $pembayaran->update(['status_pembayaran' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $pembayaran->update(['status_pembayaran' => 'gagal']);
            }

            return response()->json(['message' => 'Callback Success']);

        } catch (\Exception $e) {
            Log::error("Midtrans Callback Error: " . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
