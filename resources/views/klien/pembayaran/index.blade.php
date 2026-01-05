@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4 text-dark"><i class="bi bi-wallet2 me-2"></i>Riwayat & Tagihan Jasa</h3>

    @foreach($pendaftarans as $p)
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 rounded-pill">No. Registrasi: {{ $p->no_pendaftaran }}</span>
                <span class="text-muted small">Daftar pada: {{ $p->created_at->format('d M Y') }}</span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-1">{{ $p->paket->nama_paket }}</h5>
                    <p class="text-muted small mb-0">Total Biaya Jasa:</p>
                    <h4 class="text-dark fw-bold">Rp {{ number_format($p->paket->harga, 0, ',', '.') }}</h4>
                </div>

                <div class="col-md-5">
                    <div class="p-3 bg-light rounded-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Termin 1 (DP 50%)</span>
                            @if($p->pembayaran && str_contains($p->pembayaran->no_invoice, '-T1') && $p->pembayaran->status_pembayaran == 'lunas')
                                <span class="badge bg-success small">LUNAS</span>
                            @else
                                <span class="badge bg-warning text-dark small">PENDING</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="small">Termin 2 (Pelunasan 50%)</span>
                            @if($p->pembayaran && str_contains($p->pembayaran->no_invoice, '-T2') && $p->pembayaran->status_pembayaran == 'lunas')
                                <span class="badge bg-success small">LUNAS</span>
                            @else
                                <span class="badge bg-secondary small">BELUM DIBAYAR</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-3 text-end">
                    @php
                        $isLunasT1 = $p->pembayaran && str_contains($p->pembayaran->no_invoice, '-T1') && $p->pembayaran->status_pembayaran == 'lunas';
                        $isLunasT2 = $p->pembayaran && str_contains($p->pembayaran->no_invoice, '-T2') && $p->pembayaran->status_pembayaran == 'lunas';
                    @endphp

                    @if(!$isLunasT1)
                        <a href="{{ route('klien.pembayaran.form', $p->id_pendaftaran) }}" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                            Bayar DP (T1)
                        </a>
                    @elseif(!$isLunasT2)
                        {{-- Cek apakah sertifikat sudah ada untuk mengaktifkan tombol Pelunasan --}}
                        @if($p->dokumen->where('nama_dokumen', 'Sertifikat Halal')->first())
                            <a href="{{ route('klien.pembayaran.form', $p->id_pendaftaran) }}" class="btn btn-info text-white w-100 rounded-pill fw-bold py-2">
                                Pelunasan (T2)
                            </a>
                        @else
                            <button class="btn btn-outline-secondary w-100 rounded-pill disabled py-2" title="Menunggu Sertifikat Terbit">
                                <i class="bi bi-lock-fill"></i> Pelunasan
                            </button>
                        @endif
                    @else
                        <button class="btn btn-success w-100 rounded-pill disabled fw-bold py-2">
                            <i class="bi bi-check-circle-fill me-2"></i>PEMBAYARAN LUNAS
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
