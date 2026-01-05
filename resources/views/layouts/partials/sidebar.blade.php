<div id="sidebar-wrapper">
    <div class="sidebar-heading text-center">
        <span class="text-primary fw-bold">{{ config('app.name') }}</span>
    </div>

    <div class="list-group list-group-flush">
        {{-- MENU ADMIN --}}
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <div class="sidebar-divider">Manajemen Admin</div>
            <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i> Data Pengguna
            </a>
            {{-- Arahkan ke dashboard untuk memproses antrean pendaftaran klien --}}
            <a href="{{ route('admin.penugasan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.penugasan.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge me-2"></i> penugasan
            </a>
        @endif

        {{-- MENU KEUANGAN --}}
        @if(Auth::user()->role == 'keuangan')
            <div class="sidebar-divider">Main Menu</div>
            <a href="{{ route('keuangan.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('keuangan.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>

            <div class="sidebar-divider">Finansial & Layanan</div>
            <a href="{{ route('keuangan.paket.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('keuangan.paket.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam me-2"></i> Mengelola Paket
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Keuangan
            </a>
        @endif

        {{-- MENU KLIEN --}}
        @if(Auth::user()->role == 'klien')
            <div class="sidebar-divider">Main Menu</div>
            <a href="{{ route('klien.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('klien.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>

            <div class="sidebar-divider">Proses Sertifikasi</div>
            <a href="{{ route('klien.pendaftaran.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('klien.pendaftaran.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i> Pendaftaran Jasa
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="bi bi-tags me-2"></i> Daftar Bahan
            </a>
        @endif

        {{-- AUTH ACTION --}}
        <div class="sidebar-divider">Akun</div>
        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>
