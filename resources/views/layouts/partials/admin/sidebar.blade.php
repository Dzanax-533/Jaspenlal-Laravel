<div class="sidebar-divider">Administrator</div>
<a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid-fill me-2"></i> Dashboard
</a>
<a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
    <i class="bi bi-people-fill me-2"></i> Manajemen User
</a>

<div class="sidebar-divider">Operasional</div>
<a href="{{ route('admin.penugasan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.penugasan.*') ? 'active' : '' }}">
    <i class="bi bi-person-badge-fill me-2"></i> Pembagian Konsultan
</a>
<a href="#" class="list-group-item list-group-item-action">
    <i class="bi bi-file-earmark-text me-2"></i> Log Aktivitas
</a>
