<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIJASPENLAL-KHI') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body { overflow-x: hidden; background-color: #f4f7f6; font-family: 'Nunito', sans-serif; }

        /* Layout Structure */
        #wrapper { display: flex; width: 100%; align-items: stretch; }
        #page-content-wrapper { width: 100%; min-height: 100vh; transition: margin .25s ease-out; }

        /* Sidebar Styling */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 260px;
            margin-left: -260px;
            transition: margin .25s ease-out;
            background-color: #ffffff;
            border-right: 1px solid #e3e6f0;
            z-index: 1000;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1.25rem;
            font-size: 1.1rem;
            border-bottom: 1px solid #f8f9fc;
        }

        .sidebar-divider {
            font-size: 0.65rem;
            font-weight: 800;
            color: #b7b9cc;
            padding: 1.5rem 1.5rem 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 1.5rem;
            color: #6e707e;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .list-group-item:hover { background-color: #f8f9fc; color: #4e73df; }
        .list-group-item.active {
            background-color: #f8f9fc;
            color: #4e73df;
            font-weight: 700;
            border-right: 4px solid #4e73df;
            border-radius: 0;
        }

        /* Sidebar Toggled State */
        body.sb-sidenav-toggled #sidebar-wrapper { margin-left: 0; }

        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            body.sb-sidenav-toggled #sidebar-wrapper { margin-left: -260px; }
        }

        /* Navbar Customization */
        .navbar { background-color: #ffffff !important; border-bottom: 1px solid #e3e6f0; }
        .btn-toggle { border: none; background: transparent; font-size: 1.25rem; color: #4e73df; }
    </style>
</head>
<body>
    <div id="app">
        <div id="wrapper">
            {{-- Sidebar Dinamis Berdasarkan Role --}}
            @auth
                <div id="sidebar-wrapper">
                    <div class="sidebar-heading fw-bold text-primary">
                        <i class="bi bi-patch-check-fill me-2"></i>SIJASPEN-KHI
                    </div>
                    <div class="list-group list-group-flush">
                        @if(Auth::user()->role == 'admin')
                            @include('layouts.partials.admin.sidebar')
                        @elseif(Auth::user()->role == 'klien')
                            @include('layouts.partials.klien.sidebar')
                        @elseif(Auth::user()->role == 'konsultan')
                            @include('layouts.partials.konsultan.sidebar')
                        @elseif(Auth::user()->role == 'keuangan')
                            @include('layouts.partials.keuangan.sidebar')
                        @endif
                    </div>
                </div>
            @endauth

            <div id="page-content-wrapper" class="d-flex flex-column">
                <nav class="navbar navbar-expand-md navbar-light shadow-sm py-2">
                    <div class="container-fluid px-4">
                        @auth
                            <button class="btn-toggle me-3" id="sidebarToggle">
                                <i class="bi bi-list"></i>
                            </button>
                            <span class="text-muted d-none d-md-inline-block">
                                Role: <span class="badge bg-light text-primary border text-uppercase">{{ Auth::user()->role }}</span>
                            </span>
                        @else
                            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                                {{ config('app.name', 'SIJASPEN-KHI') }}
                            </a>
                        @endauth

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto">
                                @guest
                                    @if (Route::has('login'))
                                        <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('login') }}">Login</a></li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center text-dark fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                            <div class="text-end me-2 d-none d-sm-block">
                                                <small class="d-block lh-1">{{ Auth::user()->nama_lengkap }}</small>
                                            </div>
                                            <i class="bi bi-person-circle fs-4 text-primary"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                                            <a class="dropdown-item py-2" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bi bi-box-arrow-right me-2 text-danger"></i> {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                        </div>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>

                <main class="p-4">
                    <div class="container-fluid">
                        {{-- Menampilkan pesan error global jika profil klien tidak sinkron --}}
                        @if(session('error'))
                            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                                <i class="bi bi-exclamation-octagon me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>

                <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
                    &copy; {{ date('Y') }} <strong>{{ config('app.name') }}</strong>. All rights reserved.
                </footer>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
                });
            }
        });
    </script>
</body>
</html>
