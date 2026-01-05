@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Inisialisasi Logika Status di Paling Atas agar tidak Undefined --}}
    @php
        $sertifikat = null;
        $isLunasT2 = false;
        $perluPelunasan = false;

        if($pendaftaran) {
            // Ambil file sertifikat jika ada
            $sertifikat = $pendaftaran->dokumen->where('nama_dokumen', 'Sertifikat Halal')->first();

            // Cek detail pembayaran
            $pembayaranAktif = $pendaftaran->pembayaran;
            $noInvoice = $pembayaranAktif->no_invoice ?? '';
            $statusBayar = $pembayaranAktif->status_pembayaran ?? '';

            // Syarat Lunas T2: Invoice mengandung T2 DAN status lunas
            $isLunasT2 = str_contains($noInvoice, '-T2') && $statusBayar == 'lunas';

            // Syarat Muncul Notif Pelunasan: Sertifikat ada, tapi invoice masih T1 (DP)
            $perluPelunasan = $sertifikat && str_contains($noInvoice, '-T1') && $statusBayar == 'lunas';
        }
    @endphp

    {{-- Header Dashboard --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h1>
            <p class="text-muted">Pantau progres sertifikasi halal Anda di sini.</p>
        </div>
        <div>
            <span class="text-muted small">Terakhir login: {{ date('d M Y, H:i') }}</span>
        </div>
    </div>

    {{-- Alert Pelunasan Termin 2 --}}
    @if($perluPelunasan)
    <div class="alert alert-info border-0 shadow-sm rounded-4 p-4 mb-4 animate__animated animate__fadeIn">
        <div class="d-flex align-items-center">
            <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                <i class="bi bi-patch-check-fill text-info fs-3"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1 text-dark">Sertifikat Halal Telah Terbit!</h5>
                <p class="mb-0 text-muted small">Konsultan telah mengunggah sertifikat Anda. Silakan lakukan <strong>Pelunasan (Termin 2)</strong> untuk mengunduh file asli.</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('klien.pembayaran.form', $pendaftaran->id_pendaftaran) }}" class="btn btn-info text-white rounded-pill px-4 fw-bold shadow-sm">
                    Bayar Pelunasan <i class="bi bi-credit-card-2-back ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- Progress Tracker Rinci --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-arrow-repeat me-2"></i>Progres Sertifikasi Halal</h6>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill extra-small">
                    No. Daftar: {{ $pendaftaran->no_pendaftaran ?? '-' }}
                </span>
            </div>

            <div class="stepper-wrapper d-flex justify-content-between position-relative mb-5">
                <div class="progress position-absolute w-100" style="height: 4px; top: 18px; z-index: 1;">
                    @php
                        $percent = $pendaftaran ? (($currentStep - 1) / 5) * 100 : 0;
                    @endphp
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percent }}%; transition: width 0.8s ease;"></div>
                </div>

                @php
                    $steps = [
                        ['label' => 'Registrasi', 'icon' => 'bi-pencil-square', 'desc' => 'Selesai'],
                        ['label' => 'DP (Termin 1)', 'icon' => 'bi-wallet2', 'desc' => 'Pembayaran'],
                        ['label' => 'Dokumen', 'icon' => 'bi-file-earmark-arrow-up', 'desc' => 'Data Teknis'],
                        ['label' => 'Audit & Sidang', 'icon' => 'bi-bank', 'desc' => 'Verifikasi'],
                        ['label' => 'Pelunasan', 'icon' => 'bi-cash-stack', 'desc' => 'Termin 2'],
                        ['label' => 'Selesai', 'icon' => 'bi-patch-check-fill', 'desc' => 'Sertifikat'],
                    ];
                @endphp

                @foreach($steps as $index => $step)
                    @php $stepNum = $index + 1; @endphp
                    <div class="text-center position-relative" style="z-index: 2; width: 100px;">
                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm transition
                            {{ $currentStep >= $stepNum ? 'bg-primary text-white' : 'bg-white text-muted border' }}"
                            style="width: 40px; height: 40px;">
                            <i class="bi {{ $step['icon'] }} small"></i>
                        </div>
                        <p class="mt-2 mb-0 fw-bold" style="font-size: 0.7rem; color: {{ $currentStep >= $stepNum ? '#4e73df' : '#b7b9cc' }}">
                            {{ $step['label'] }}
                        </p>
                        <span class="extra-small text-muted d-none d-md-block">{{ $step['desc'] }}</span>
                    </div>
                @endforeach
            </div>

            <div class="alert bg-light border-0 rounded-4 p-3 d-flex align-items-center">
                <i class="bi bi-info-circle-fill text-primary fs-4 me-3"></i>
                <div>
                    <h6 class="fw-bold mb-1 small">Status & Instruksi:</h6>
                    <p class="mb-0 extra-small text-muted">
                        @if(!$pendaftaran)
                            Silakan pilih paket pendampingan untuk memulai proses sertifikasi halal Anda.
                        @elseif($currentStep == 2)
                            Pendaftaran diterima. Silakan lakukan <strong>Pembayaran DP (50%)</strong> untuk membuka akses upload dokumen.
                        @elseif($currentStep == 3)
                            Akses dokumen terbuka. Mohon lengkapi <strong>Data Bahan dan Dokumen Persyaratan</strong>.
                        @elseif($currentStep == 4)
                            Dokumen sedang diverifikasi oleh Konsultan dan menunggu proses audit serta Sidang Fatwa MUI.
                        @elseif($currentStep == 5)
                            Proses audit selesai dan sertifikat siap. Mohon lakukan <strong>Pelunasan (Termin 2)</strong>.
                        @elseif($currentStep == 6)
                            Seluruh proses selesai. Anda dapat mengunduh Sertifikat Halal asli pada menu yang tersedia.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Ringkasan Statistik & Akses Menu (Singkat) --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                {{-- Status Card --}}
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 py-2 border-start border-primary border-5">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 small">Status</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800 text-uppercase">{{ $pendaftaran->status_pendaftaran ?? 'N/A' }}</div>
                                </div>
                                <div class="col-auto"><i class="bi bi-info-circle-fill fs-2 text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Pembayaran Card --}}
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 py-2 border-start border-warning border-5">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 small">Pembayaran</div>
                                    <div class="h6 mb-0 font-weight-bold">
                                        @if($pendaftaran && $pendaftaran->pembayaran)
                                            <span class="text-{{ $pembayaranAktif->status_pembayaran == 'lunas' ? 'success' : 'warning' }}">
                                                {{ strtoupper($pembayaranAktif->status_pembayaran) }}
                                                {{ str_contains($pembayaranAktif->no_invoice, '-T1') ? '(DP)' : '(LUNAS)' }}
                                            </span>
                                        @else
                                            <span class="text-muted small">BELUM ADA DATA</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto"><i class="bi bi-wallet2 fs-2 text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Akses Cepat --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0"><h6 class="m-0 font-weight-bold text-primary">Menu Utama</h6></div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <a href="{{ route('klien.pendaftaran.daftar') }}" class="text-decoration-none">
                                <div class="p-2 bg-light rounded-4 hover-shadow transition">
                                    <i class="bi bi-clipboard-plus fs-2 text-primary"></i>
                                    <p class="mt-1 mb-0 extra-small fw-bold text-dark">Daftar</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="{{ route('klien.pembayaran.index') }}" class="text-decoration-none">
                                <div class="p-2 bg-light rounded-4 hover-shadow transition">
                                    <i class="bi bi-credit-card fs-2 text-warning"></i>
                                    <p class="mt-1 mb-0 extra-small fw-bold text-dark">Bayar</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-3">
                            @if($pendaftaran && $currentStep >= 3)
                                <a href="{{ route('klien.dokumen') }}" class="text-decoration-none">
                                    <div class="p-2 bg-white rounded-4 hover-shadow transition border border-success">
                                        <i class="bi bi-cloud-arrow-up fs-2 text-success"></i>
                                        <p class="mt-1 mb-0 extra-small fw-bold text-dark">Dokumen</p>
                                    </div>
                                </a>
                            @else
                                <div class="p-2 bg-light rounded-4 opacity-50"><i class="bi bi-lock fs-2"></i><p class="mt-1 mb-0 extra-small fw-bold">Kunci</p></div>
                            @endif
                        </div>
                        <div class="col-3">
                            @if($isLunasT2 && $sertifikat)
                                <a href="{{ asset('storage/' . $sertifikat->file_path) }}" target="_blank" class="text-decoration-none">
                                    <div class="p-2 bg-primary text-white rounded-4 hover-shadow transition">
                                        <i class="bi bi-download fs-2"></i>
                                        <p class="mt-1 mb-0 extra-small fw-bold">Sertifikat</p>
                                    </div>
                                </a>
                            @else
                                <div class="p-2 bg-light rounded-4 opacity-50"><i class="bi bi-file-lock fs-2"></i><p class="mt-1 mb-0 extra-small fw-bold">Sertifikat</p></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Paket --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <i class="bi bi-patch-check position-absolute end-0 bottom-0 mb-n3 me-n3 opacity-25" style="font-size: 7rem;"></i>
                    <h6 class="text-white-50 small text-uppercase fw-bold">Paket Aktif</h6>
                    @if($pendaftaran)
                        <h4 class="fw-bold">{{ $pendaftaran->paket->nama_paket }}</h4>
                        <p class="small opacity-75">ID: {{ $pendaftaran->no_pendaftaran }}</p>
                        <hr class="bg-white opacity-25">
                        <small>Konsultan Pendamping:</small><br>
                        <strong>{{ $pendaftaran->konsultan->nama_lengkap ?? 'Proses Penugasan' }}</strong>
                    @else
                        <h5 class="mb-3">Belum Ada Paket</h5>
                        <a href="{{ route('klien.pendaftaran.daftar') }}" class="btn btn-light btn-sm rounded-pill px-3">Pilih Paket</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; transform: translateY(-3px); }
    .transition { transition: all 0.3s ease; }
    .border-5 { border-width: 0 0 0 5px !important; }
    .extra-small { font-size: 0.65rem; }
</style>
@endsection
