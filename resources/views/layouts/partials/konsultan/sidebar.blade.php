<div class="sidebar-divider">Konsultan</div>
<a href="{{ route('konsultan.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('konsultan.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2 me-2"></i> Dashboard
</a>

<div class="sidebar-divider">Pendampingan</div>
<a href="{{ route('konsultan.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('konsultan.detail') ? 'active' : '' }}">
    <i class="bi bi-person-check-fill me-2"></i> Klien Saya
</a>
<a href="#" class="list-group-item list-group-item-action">
    <i class="bi bi-chat-dots me-2"></i> Chat Klien
</a>
