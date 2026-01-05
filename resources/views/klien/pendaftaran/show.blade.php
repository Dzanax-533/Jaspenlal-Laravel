@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0">Detail Pendaftaran</h3>
                    <p class="text-muted">No. Registrasi: <span class="text-primary fw-bold">{{ $pendaftaran->no_pendaftaran }}</span></p>
                </div>
                <a href="{{ route('klien.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>

            <div class="row g-4">
                {{-- Kolom Kiri: Informasi Teknis --}}
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Paket & Teknis</h5>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Paket Pendampingan</div>
                            <div class="col-sm-7 fw-bold text-primary">{{ $pendaftaran->paket->nama_paket }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Skala Usaha</div>
                            <div class="col-sm-7">
                                <span class="badge bg-primary bg-opacity-10 text-primary text-uppercase px-3 rounded-pill">
                                    {{ $pendaftaran->skala_usaha }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Jumlah Menu Tambahan</div>
                            <div class="col-sm-7 fw-bold">{{ $pendaftaran->jumlah_menu }} Item</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">Fasilitas/Outlet Tambahan</div>
                            <div class="col-sm-7 fw-bold">{{ $pendaftaran->jumlah_outlet }} Outlet</div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-sm-5 text-muted">Catatan/Lokasi</div>
                            <div class="col-sm-7 text-muted small">{{ $pendaftaran->catatan ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Card Status Progres --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-3">Status Alur Sertifikasi</h5>
                        @php
                            $statusStyle = [
                                'pending' => ['bg' => 'bg-warning', 'icon' => 'bi-hourglass-split', 'text' => 'Menunggu Pembayaran'],
                                'bayar'   => ['bg' => 'bg-success', 'icon' => 'bi-cloud-arrow-up', 'text' => 'Sudah Bayar - Silakan Lengkapi Dokumen'],
                                'proses'  => ['bg' => 'bg-info', 'icon' => 'bi-gear-wide-connected', 'text' => 'Dokumen Sedang Diverifikasi'],
                                'sidang'  => ['bg' => 'bg-primary', 'icon' => 'bi-bank', 'text' => 'Proses Sidang Fatwa'],
                                'selesai' => ['bg' => 'bg-dark', 'icon' => 'bi-patch-check-fill', 'text' => 'Sertifikat Halal Terbit'],
                            ];
                            $curr = $statusStyle[$pendaftaran->status_pendaftaran] ?? $statusStyle['pending'];
                        @endphp

                        <div class="d-flex align-items-center p-3 rounded-4 {{ $curr['bg'] }} bg-opacity-10 text-dark border-start border-{{ str_replace('bg-', '', $curr['bg']) }} border-5">
                            <i class="bi {{ $curr['icon'] }} fs-2 me-3 text-{{ str_replace('bg-', '', $curr['bg']) }}"></i>
                            <div>
                                <div class="fw-bold">{{ $curr['text'] }}</div>
                                <div class="small opacity-75">Update terakhir: {{ $pendaftaran->updated_at->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Konsultan & Pembayaran --}}
                <div class="col-md-5">
                    {{-- Card Konsultan --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h5 class="fw-bold mb-3">Konsultan Pendamping</h5>
                        @if($pendaftaran->id_konsultan)
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3 text-primary">
                                    <i class="bi bi-person-badge fs-3"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $pendaftaran->konsultan->nama_lengkap }}</div>
                                    <div class="small text-muted">Akan membimbing pengisian SJPH Anda</div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3 border border-dashed rounded-4">
                                <i class="bi bi-person-dash text-muted fs-2"></i>
                                <p class="text-muted small mb-0 mt-2">Menunggu Penugasan Konsultan</p>
                            </div>
                        @endif
                    </div>

                    {{-- Card Tagihan & Pembayaran Midtrans --}}
                    <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4">
                        <h6 class="text-primary fw-bold text-uppercase small mb-3">Ringkasan Biaya</h6>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-white-50 small">Total yang harus dibayar</span>
                            <span class="fw-bold h3 mb-0 text-white">
                                Rp {{ number_format($pendaftaran->paket->harga, 0, ',', '.') }}
                            </span>
                        </div>

                        <hr class="border-secondary my-3 opacity-25">

                        @if($pendaftaran->status_pendaftaran == 'pending')
                            {{-- Jika status pending, tampilkan tombol bayar --}}
                            <a href="{{ route('klien.pembayaran.form', $pendaftaran->id_pendaftaran) }}" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow">
                                <i class="bi bi-credit-card me-2"></i>Lanjut ke Pembayaran
                            </a>
                            <p class="extra-small text-white-50 text-center mt-3 mb-0 italic">
                                *Pembayaran menggunakan gerbang otomatis Midtrans (QRIS, VA, E-Wallet)
                            </p>
                        @elseif($pendaftaran->status_pendaftaran == 'bayar')
                            {{-- Jika sudah bayar, arahkan ke upload --}}
                            <div class="alert alert-success bg-success bg-opacity-10 border-0 text-success small rounded-4 mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>Pembayaran Terverifikasi
                            </div>
                            <button class="btn btn-outline-light w-100 rounded-pill py-3 fw-bold mt-3 shadow-sm" disabled>
                                <i class="bi bi-cloud-check me-2"></i>Pembayaran Selesai
                            </button>
                        @else
                             <div class="text-center py-2">
                                <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-bold">TRANSAKSI SELESAI</span>
                             </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-5 { border-width: 0 0 0 5px !important; }
    .extra-small { font-size: 0.7rem; }
    .italic { font-style: italic; }
</style>
@endsection
