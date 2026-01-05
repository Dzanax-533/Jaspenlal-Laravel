@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4 text-center">
        <h3 class="fw-bold text-dark">Pilih Paket Pendampingan</h3>
        <p class="text-muted">Investasi cerdas untuk kelancaran sertifikasi halal usaha Anda.</p>
    </div>

    <div class="row justify-content-center">
        @foreach($pakets as $p)
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="mb-3">
                            <h4 class="fw-bold text-primary mb-1">{{ $p->nama_paket }}</h4>
                            <h2 class="fw-bold text-dark">Rp {{ number_format($p->harga, 0, ',', '.') }}</h2>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i> Estimasi {{ $p->durasi_hari }} Hari Kerja</small>
                        </div>

                        <p class="text-muted small mb-4">
                            {{ $p->deskripsi }}
                        </p>

                        <div class="mb-4">
                            <p class="fw-bold small mb-2 text-uppercase text-secondary">Fasilitas & Benefit:</p>
                            <ul class="list-unstyled mb-0">
                                @foreach(explode(',', $p->benefit) as $benefit)
                                    <li class="small mb-2 d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                        <span>{{ trim($benefit) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-auto pt-3 border-top">
                            <a href="{{ route('klien.pendaftaran.create', $p->id_paket) }}" class="btn btn-primary w-100 shadow-sm rounded-pill py-2 fw-bold">
                                Pilih Paket Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection