<a href="{{ route('keuangan.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('keuangan.dashboard') ? 'active' : '' }}">
    <i class="bi bi-graph-up-arrow me-2"></i> Dashboard
</a>

<div class="sidebar-divider">Mengelola Keuangan</div>

<a href="{{ route('keuangan.pendaftaran.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('keuangan.pendaftaran.*') ? 'active' : '' }}">
    <i class="bi bi-cash-stack me-2"></i> Verifikasi Pembayaran
</a>

<div class="sidebar-divider">Kelola Paket Pendampingan</div>

<a href="{{ route('keuangan.paket.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('keuangan.paket.*') ? 'active' : '' }}">
    <i class="bi bi-box-fill me-2"></i> Paket Jasa
</a>

<a href="{{ route('keuangan.pengaturan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('keuangan.pengaturan.*') ? 'active' : '' }}">
    <i class="bi bi-gear-fill me-2"></i> Parameter Biaya
</a>