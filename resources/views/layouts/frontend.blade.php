<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Solusi Sertifikasi Halal</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { font-family: 'Nunito', sans-serif; color: #333; overflow-x: hidden; }

        /* Custom Header Styling */
        .custom-navbar {
            border-bottom: 1px solid rgba(0,0,0,0.05);
            backdrop-filter: blur(15px);
            background-color: rgba(255, 255, 255, 0.98) !important;
            transition: all 0.3s ease;
        }

        .navbar-brand span {
            letter-spacing: -1px;
        }

        /* Nav Link Effects */
        .custom-navbar .nav-link {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #444 !important;
            position: relative;
            transition: 0.3s;
        }

        .custom-navbar .nav-link:hover,
        .custom-navbar .nav-link.active {
            color: #0d6efd !important;
        }

        .custom-navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #0d6efd;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .custom-navbar .nav-link:hover::after,
        .custom-navbar .nav-link.active::after {
            width: 20px;
        }

        /* Auth Button Styling */
        .btn-login {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #444 !important;
            transition: 0.3s;
        }

        .btn-login:hover {
            color: #0d6efd !important;
            transform: translateY(-1px);
        }

        .btn-register {
            border-radius: 50px;
            padding: 0.6rem 1.8rem;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.15);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-register:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.25) !important;
        }

        .btn-dashboard {
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* Footer Styling */
        footer { background: #1a1d20; color: #adb5bd; padding: 4rem 0 2rem; }
        footer a { color: #adb5bd; text-decoration: none; transition: 0.2s; }
        footer a:hover { color: #fff; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top py-3 custom-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm" style="width: 42px; height: 42px;">
                    <i class="bi bi-shield-check text-white fs-4"></i>
                </div>
                <div class="d-flex flex-column">
                    <span class="fw-bold fs-4 text-dark lh-1">{{ config('app.name') }}</span>
                    <small class="text-primary fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">SISTEM SERTIFIKASI</small>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-grid-fill text-primary"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('welcome') ? 'active' : '' }}" href="{{ route('welcome') }}">BERANDA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">TENTANG</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">KONTAK</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    @guest
                        <a class="btn btn-link btn-login text-decoration-none me-3" href="{{ route('login') }}">
                            MASUK
                        </a>
                        <a class="btn btn-primary btn-register shadow-sm" href="{{ route('register') }}">
                            DAFTAR <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                        </a>
                    @else
                        <li class="nav-item list-unstyled">
                            @if (Route::has('home'))
                                <a class="btn btn-primary btn-dashboard shadow-sm" href="{{ route('home') }}">
                                    <i class="bi bi-grid-fill me-2 small"></i>DASHBOARD
                                </a>
                            @else
                                <a class="btn btn-primary btn-dashboard shadow-sm" href="{{ url('/home') }}">
                                    <i class="bi bi-grid-fill me-2 small"></i>DASHBOARD
                                </a>
                            @endif
                        </li>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container text-center text-md-start">
            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="text-white fw-bold mb-3">{{ config('app.name') }}</h5>
                    <p class="small lh-lg">Lembaga Pendampingan Sertifikasi Halal yang berkomitmen membantu UMKM dan Industri dalam mempercepat proses sertifikasi dengan teknologi digital yang transparan dan akuntabel.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-bold mb-3">Tautan Cepat</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('welcome') }}">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Kontak Kami</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-bold mb-3">Ikuti Kami</h6>
                    <div class="fs-4 text-white">
                        <i class="bi bi-facebook me-3"></i>
                        <i class="bi bi-instagram me-3"></i>
                        <i class="bi bi-linkedin"></i>
                    </div>
                </div>
            </div>
            <hr class="my-4 border-secondary opacity-25">
            <p class="text-center small mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
