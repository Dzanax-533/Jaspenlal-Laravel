@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <section class="hero-section text-white text-center d-flex align-items-center justify-content-center" style="background-image: url('https://ihatec.com/wp-content/uploads/2023/12/ihatec-web-desktop.webp'); background-size: cover; background-position: center; min-height: 500px;">
        <div class="hero-overlay p-4">
            <h1 class="display-4 fw-bold mb-3">Solusi Sertifikasi Halal Digital Terdepan</h1>
            <p class="lead mb-4">Membantu UMKM dan perusahaan besar mendapatkan sertifikasi halal dengan cepat, mudah, dan transparan.</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow-sm">Mulai Sekarang <i class="bi bi-arrow-right"></i></a>
        </div>
    </section>

    <section class="services-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Fokus Layanan Kami</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <i class="bi bi-file-earmark-check-fill text-primary fs-1 mb-3"></i>
                            <h5 class="card-title fw-bold">Pendampingan Lengkap</h5>
                            <p class="card-text">Dari persiapan dokumen hingga penerbitan sertifikat, kami dampingi Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <i class="bi bi-cloud-arrow-up-fill text-primary fs-1 mb-3"></i>
                            <h5 class="card-title fw-bold">Platform Digital</h5>
                            <p class="card-text">Manajemen proses sertifikasi yang efisien melalui platform online.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <i class="bi bi-shield-fill-check text-primary fs-1 mb-3"></i>
                            <h5 class="card-title fw-bold">Verifikasi Transparan</h5>
                            <p class="card-text">Proses verifikasi dokumen yang jelas dan dapat dipantau setiap saat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="https://via.placeholder.com/600x400/0d6efd/ffffff?text=About+Us" class="img-fluid rounded shadow-sm" alt="Tentang Kami">
                </div>
                <div class="col-md-6">
                    <h2 class="mb-4 fw-bold">Tentang Kami</h2>
                    <p class="lead">Kami adalah mitra terpercaya Anda dalam mendapatkan sertifikasi halal di Indonesia. Dengan tim ahli dan platform digital, kami berkomitmen membantu bisnis Anda tumbuh dan meraih kepercayaan konsumen.</p>
                    <p>Misi kami adalah menyederhanakan proses sertifikasi halal yang seringkali dianggap rumit, menjadikannya mudah diakses oleh semua pelaku usaha.</p>
                    <a href="#" class="btn btn-outline-primary mt-3">Pelajari Lebih Lanjut <i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section class="why-choose-us-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Mengapa Memilih Kami?</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-check-circle-fill text-success fs-3 me-3"></i>
                        <div>
                            <h5 class="fw-bold">Proses Cepat & Efisien</h5>
                            <p class="text-muted">Platform digital kami mempercepat seluruh tahapan sertifikasi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-people-fill text-success fs-3 me-3"></i>
                        <div>
                            <h5 class="fw-bold">Tim Konsultan Berpengalaman</h5>
                            <p class="text-muted">Didukung oleh konsultan yang ahli di bidang syariah dan regulasi halal.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-currency-dollar text-success fs-3 me-3"></i>
                        <div>
                            <h5 class="fw-bold">Harga Kompetitif & Transparan</h5>
                            <p class="text-muted">Tidak ada biaya tersembunyi, semua kalkulasi jelas di awal.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-headset text-success fs-3 me-3"></i>
                        <div>
                            <h5 class="fw-bold">Dukungan Pelanggan Optimal</h5>
                            <p class="text-muted">Tim kami siap membantu Anda kapan saja dibutuhkan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section bg-primary text-white text-center py-5">
        <div class="container">
            <h2 class="fw-bold mb-3">Siap Mengembangkan Bisnis Anda?</h2>
            <p class="lead mb-4">Bergabunglah dengan ratusan pelaku usaha yang telah meraih sertifikasi halal bersama kami.</p>
            <a href="{{ route('klien.dashboard') }}" class="btn btn-light btn-lg shadow-sm">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>
        </div>
    </section>

    <footer class="bg-dark text-white-50 py-4">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="text-white fw-bold">{{ config('app.name', 'Laravel') }}</h6>
                    <p>Jl. Contoh No. 123, Kota Anda, 12345</p>
                    <p>Email: info@kpapp.com</p>
                    <p>Telp: (021) 123-4567</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="text-white fw-bold">Tautan Cepat</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Layanan Kami</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Tentang Kami</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Hubungi Kami</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white fw-bold">Ikuti Kami</h6>
                    <a href="#" class="text-white me-2"><i class="bi bi-facebook fs-4"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-instagram fs-4"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-linkedin fs-4"></i></a>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>

<style>
    /* Custom styles for Hero Section */
    .hero-section {
        position: relative;
        background-color: #343a40; /* Fallback color */
    }
    .hero-overlay {
        position: relative;
        z-index: 1;
        background-color: rgba(0,0,0,0.5); /* Semi-transparent overlay */
        padding: 50px 20px;
        border-radius: 8px;
    }
    .hero-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4); /* Dark overlay */
        z-index: 0;
    }

    /* General Section Styling */
    section { padding: 80px 0; }
    h1, h2, h3, h4, h5, h6 { color: #212529; }
    .btn-primary { background-color: #0d6efd; border-color: #0d6efd; }
    .btn-primary:hover { background-color: #0b5ed7; border-color: #0a58ca; }
    .text-primary { color: #0d6efd !important; }

    /* Card shadows */
    .card {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.05) !important;
    }
</style>
@endsection
