@extends('layouts.frontend')

@section('content')
<section class="py-5 text-center bg-light" style="background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.8)), url('https://ihatec.com/wp-content/uploads/2023/12/ihatec-web-desktop.webp'); background-size: cover;">
    <div class="container py-5">
        <h1 class="display-3 fw-bold text-dark mb-4">Partner Strategis <br><span class="text-primary">Sertifikasi Halal</span></h1>
        <p class="lead mb-5 px-lg-5">Membantu Bisnis Anda Mendapatkan Sertifikat Halal dengan Cepat, Tepat, dan Terpercaya melalui Pendampingan Digital.</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 shadow">Daftar Sekarang</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Layanan Sertifikasi</h2>
        <div class="row g-4">
            @foreach($pakets as $paket)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="bi bi-patch-check fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">{{ $paket->nama_paket }}</h4>
                        <p class="text-muted small mb-4">{{ $paket->deskripsi }}</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4">Pilih Paket</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
