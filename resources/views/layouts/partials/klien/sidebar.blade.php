<div class="sidebar-divider">Menu Utama</div>
<a href="{{ route('klien.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('klien.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2 me-2"></i> Dashboard
</a>
<a href="{{ route('klien.pendaftaran.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('klien.pendaftaran.index', 'klien.pendaftaran.daftar', 'klien.pendaftaran.create') ? 'active' : '' }}">
    <i class="bi bi-clipboard-check me-2"></i> Pendaftaran Jasa
</a>

<div class="sidebar-divider">Proses Sertifikasi</div>
<a href="{{ route('klien.pembayaran.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('klien.pembayaran.*') ? 'active' : '' }}">
    <i class="bi bi-wallet2 me-2"></i> Pembayaran Jasa
</a>

{{-- MENU BARU: UPLOAD DOKUMEN --}}
@php
    $cekPendaftaran = \App\Models\Pendaftaran::where('id_klien', Auth::user()->klien->id_klien)->latest()->first();
    $aksesUpload = $cekPendaftaran && $cekPendaftaran->status_pendaftaran !== 'pending';
@endphp

@if($aksesUpload)
    <a href="{{ route('klien.dokumen.index', $cekPendaftaran->id_pendaftaran) }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('klien.dokumen.index') ? 'active' : '' }}">
        <i class="bi bi-cloud-arrow-up me-2"></i> Upload Dokumen
    </a>
@else
    <a href="javascript:void(0)" class="list-group-item list-group-item-action text-muted opacity-75"
       style="cursor: not-allowed;" title="Selesaikan Pembayaran DP untuk membuka menu ini">
        <i class="bi bi-lock-fill me-2"></i> Upload Dokumen
        <span class="badge bg-secondary float-end" style="font-size: 0.6rem;">Locked</span>
    </a>
@endif

@if($aksesUpload)
    <a href="{{ route('klien.bahan.index', $cekPendaftaran->id_pendaftaran) }}"
       class="list-group-item list-group-item-action {{ request()->routeIs('klien.bahan.index') ? 'active' : '' }}">
        <i class="bi bi-cloud-arrow-up me-2"></i> Upload Bahan
    </a>
@else
    <a href="javascript:void(0)" class="list-group-item list-group-item-action text-muted opacity-75"
       style="cursor: not-allowed;" title="Selesaikan Pembayaran DP untuk membuka menu ini">
        <i class="bi bi-lock-fill me-2"></i> Upload bahan
        <span class="badge bg-secondary float-end" style="font-size: 0.6rem;">Locked</span>
    </a>
@endif

<div class="sidebar-divider">Output</div>
@php
    $isLunasT2 = $cekPendaftaran && $cekPendaftaran->pembayaran && str_contains($cekPendaftaran->pembayaran->no_invoice, '-T2') && $cekPendaftaran->pembayaran->status_pembayaran == 'lunas';
    $sertifikatAda = $cekPendaftaran ? $cekPendaftaran->dokumen->where('nama_dokumen', 'Sertifikat Halal')->first() : null;
@endphp

@if($isLunasT2 && $sertifikatAda)
    <a href="{{ asset('storage/' . $sertifikatAda->file_path) }}" target="_blank" class="list-group-item list-group-item-action bg-primary text-white">
        <i class="bi bi-patch-check me-2 text-white"></i> Unduh Sertifikat
    </a>
@else
    <a href="javascript:void(0)" class="list-group-item list-group-item-action text-muted opacity-50" style="cursor: not-allowed;">
        <i class="bi bi-patch-check me-2"></i> Unduh Sertifikat
    </a>
@endif
