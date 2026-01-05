@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Status Pendaftaran Saya</h3>
            <p class="text-muted">Pembayaran diproses secara otomatis melalui gerbang pembayaran aman.</p>
        </div>
        <a href="{{ route('klien.pendaftaran.daftar') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Daftar Baru
        </a>
    </div>

    <div class="row">
        @forelse($pendaftarans as $p)
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-3 bg-light p-4 d-flex flex-column justify-content-center border-end">
                            <span class="badge bg-primary bg-opacity-10 text-primary mb-2 w-fit px-3">{{ $p->no_pendaftaran }}</span>
                            <h5 class="fw-bold text-dark mb-1">{{ $p->paket->nama_paket ?? 'Paket N/A' }}</h5>
                            <p class="text-muted small mb-0">Daftar: {{ $p->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="col-md-6 p-4">
                            @php
                                $progress = 0;
                                if($p->status_pendaftaran == 'pending') $progress = 33;
                                elseif($p->status_pendaftaran == 'bayar') $progress = 66;
                                elseif($p->status_pendaftaran == 'selesai') $progress = 100;
                            @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold text-uppercase text-muted">Progress Sertifikasi</span>
                                <span class="small fw-bold text-primary">{{ $progress }}%</span>
                            </div>
                            <div class="progress rounded-pill mb-3" style="height: 10px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                     role="progressbar" style="width: {{ $progress }}%">
                                </div>
                            </div>

                            <div class="row text-center mt-3">
                                <div class="col-4">
                                    <i class="bi bi-person-check-fill {{ $p->id_konsultan ? 'text-primary' : 'text-muted' }}"></i>
                                    <div class="small mt-1 {{ $p->id_konsultan ? 'fw-bold' : '' }}">Assign Konsultan</div>
                                </div>
                                <div class="col-4">
                                    <i class="bi bi-credit-card-2-front-fill {{ ($p->pembayaran && $p->pembayaran->status_pembayaran == 'lunas') ? 'text-primary' : 'text-muted' }}"></i>
                                    <div class="small mt-1 {{ ($p->pembayaran && $p->pembayaran->status_pembayaran == 'lunas') ? 'fw-bold' : '' }}">Pembayaran</div>
                                </div>
                                <div class="col-4">
                                    <i class="bi bi-file-earmark-medical-fill {{ $p->status_pendaftaran == 'selesai' ? 'text-primary' : 'text-muted' }}"></i>
                                    <div class="small mt-1 {{ $p->status_pendaftaran == 'selesai' ? 'fw-bold' : '' }}">Proses Dokumen</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 p-4 bg-white d-flex flex-column justify-content-center text-center">
                            @if($p->total_biaya > 0)
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Tagihan Pembayaran</small>
                                <h4 class="fw-bold text-dark">Rp {{ number_format($p->total_biaya, 0, ',', '.') }}</h4>

                                @if($p->pembayaran && $p->pembayaran->status_pembayaran == 'lunas')
                                    <button class="btn btn-success rounded-pill btn-sm mt-2 fw-bold" disabled>
                                        <i class="bi bi-check-circle me-1"></i> Terbayar
                                    </button>
                                @else
                                    {{-- PERBAIKAN: Menggunakan id_pendaftaran sebagai parameter rute --}}
                                    <a href="{{ route('klien.pembayaran.form', $p->id_pendaftaran) }}" class="btn btn-primary rounded-pill btn-sm mt-2 fw-bold shadow-sm">
                                        Bayar Sekarang
                                    </a>
                                @endif
                            @else
                                <div class="py-2">
                                    <div class="spinner-border spinner-border-sm text-warning me-2" role="status"></div>
                                    <span class="text-warning fw-bold small">Menunggu Admin</span>
                                </div>
                                <p class="text-muted small mb-0 mt-1">Penentuan biaya tambahan...</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h5 class="text-muted">Anda belum memiliki riwayat pendaftaran.</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection
