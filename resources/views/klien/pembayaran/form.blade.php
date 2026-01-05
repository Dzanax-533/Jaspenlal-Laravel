@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="row g-0">
                    {{-- Sisi Kiri: Rincian Paket --}}
                    <div class="col-md-5 bg-primary p-4 text-white d-flex flex-column justify-content-center">
                        <h6 class="text-white-50 small text-uppercase fw-bold">Paket Terpilih</h6>
                        <h3 class="fw-bold mb-4">{{ $pendaftaran->paket->nama_paket }}</h3>

                        <div class="mb-4">
                            <small class="d-block text-white-50">Total Harga Layanan:</small>
                            <h4 class="fw-bold">Rp {{ number_format($pendaftaran->total_biaya, 0, ',', '.') }}</h4>
                        </div>

                        <ul class="list-unstyled small">
                            <li class="mb-2"><i class="bi bi-check-circle-fill me-2"></i> Pendampingan Intensif</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill me-2"></i> Pengurusan SJPH</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill me-2"></i> Update Status Real-time</li>
                        </ul>
                    </div>

                    {{-- Sisi Kanan: Kalkulasi Termin --}}
                    <div class="col-md-7 p-4 bg-white">
                        <h5 class="fw-bold mb-4">Rincian Pembayaran Berjangka</h5>

                        @php
                            $pembayaran = $pendaftaran->pembayaran;
                            // Fallback jika pembayaran null agar tidak error blank
                            $tagihanSekarang = $pembayaran ? $pembayaran->jumlah_pembayaran : ($pendaftaran->total_biaya / 2);
                            $noInvoice = $pembayaran ? $pembayaran->no_invoice : '';
                            $isTermin2 = str_contains($noInvoice, '-T2');
                            $estimasiLain = $pendaftaran->total_biaya - $tagihanSekarang;
                        @endphp

                        <div class="p-3 bg-light rounded-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 {{ $isTermin2 ? 'opacity-50' : '' }}">
                                <div>
                                    <h6 class="mb-0 fw-bold">Termin 1: Down Payment (50%)</h6>
                                    <small class="text-muted small">Untuk membuka akses Upload Dokumen</small>
                                </div>
                                <span class="fw-bold {{ !$isTermin2 ? 'text-primary' : '' }}">
                                    Rp {{ number_format($isTermin2 ? $estimasiLain : $tagihanSekarang, 0, ',', '.') }}
                                </span>
                            </div>

                            <hr class="my-2 opacity-10">

                            <div class="d-flex justify-content-between align-items-center {{ !$isTermin2 ? 'opacity-50' : '' }}">
                                <div>
                                    <h6 class="mb-0 fw-bold">Termin 2: Pelunasan (50%)</h6>
                                    <small class="text-muted small">Dibayar setelah Sertifikat terbit</small>
                                </div>
                                <span class="fw-bold {{ $isTermin2 ? 'text-primary' : '' }}">
                                    Rp {{ number_format($isTermin2 ? $tagihanSekarang : $estimasiLain, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 small rounded-4 mb-4 shadow-sm">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Tagihan saat ini: <strong>{{ $isTermin2 ? 'Pelunasan (T2)' : 'DP (T1)' }}</strong> sebesar
                            <strong class="fs-6">Rp {{ number_format($tagihanSekarang, 0, ',', '.') }}</strong>.
                        </div>

                        <button id="pay-button" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow">
                            Bayar {{ $isTermin2 ? 'Pelunasan' : 'Termin 1' }} Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){ window.location.href = "{{ route('klien.dashboard') }}?status=success"; },
            onPending: function(result){ window.location.href = "{{ route('klien.pembayaran.index') }}"; },
            onError: function(result){ alert("Pembayaran gagal, silakan coba lagi."); }
        });
    };
</script>
@endsection
