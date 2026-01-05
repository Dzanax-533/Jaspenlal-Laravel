@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            {{-- Header Section --}}
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('klien.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active">Berkas Persyaratan</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold mb-0 text-dark">Pusat Dokumen Sertifikasi</h2>
                    <p class="text-muted mb-0">Lengkapi berkas di bawah ini untuk mempercepat proses verifikasi oleh konsultan.</p>
                </div>
                <div class="text-end">
                    <div class="card border-0 shadow-sm px-3 py-2 rounded-4 bg-white">
                        <span class="text-muted small d-block">Progres Berkas</span>
                        @php
                            $totalSyarat = 5;
                            $totalUpload = $pendaftaran->dokumen->count();
                            $persen = ($totalUpload / $totalSyarat) * 100;
                        @endphp
                        <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1 me-2" style="height: 6px; width: 100px;">
                                <div class="progress-bar bg-success" style="width: {{ $persen }}%"></div>
                            </div>
                            <span class="fw-bold text-dark">{{ $totalUpload }}/{{ $totalSyarat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dokumen Grid --}}
            <div class="row g-4">
                @php
                    $listSyarat = [
                        ['id' => 'nib', 'nama' => 'NIB (Nomor Induk Berusaha)', 'icon' => 'bi-file-earmark-medical', 'color' => 'primary', 'desc' => 'Gunakan NIB terbaru dengan RBA.'],
                        ['id' => 'ktp', 'nama' => 'KTP Pemilik', 'icon' => 'bi-person-badge', 'color' => 'info', 'desc' => 'Pastikan foto KTP terbaca jelas.'],
                        ['id' => 'sjph', 'nama' => 'Manual SJPH', 'icon' => 'bi-book-half', 'color' => 'warning', 'desc' => 'Sistem Jaminan Produk Halal.'],
                        ['id' => 'menu', 'nama' => 'Daftar Menu & Bahan', 'icon' => 'bi-card-list', 'color' => 'success', 'desc' => 'Daftar produk yang diajukan.'],
                        ['id' => 'foto', 'nama' => 'Foto Fasilitas Produksi', 'icon' => 'bi-camera-fill', 'color' => 'danger', 'desc' => 'Area produksi dan dapur.'],
                    ];
                @endphp

                @foreach($listSyarat as $s)
                    @php
                        $dok = $pendaftaran->dokumen->where('nama_dokumen', $s['nama'])->first();
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="icon-shape bg-{{ $s['color'] }} bg-opacity-10 text-{{ $s['color'] }} rounded-4 p-3">
                                        <i class="bi {{ $s['icon'] }} fs-3"></i>
                                    </div>
                                    <div>
                                        @if($dok)
                                            <span class="badge rounded-pill {{ $dok->status_validasi == 'valid' ? 'bg-success' : ($dok->status_validasi == 'perbaikan' ? 'bg-danger' : 'bg-warning') }}">
                                                {{ strtoupper($dok->status_validasi) }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border rounded-pill">BELUM ADA</span>
                                        @endif
                                    </div>
                                </div>

                                <h5 class="fw-bold text-dark mb-1">{{ $s['nama'] }}</h5>
                                <p class="small text-muted mb-4">{{ $s['desc'] }}</p>

                                @if($dok)
                                    <div class="p-3 bg-light rounded-4 mb-3 d-flex align-items-center border border-dashed border-2">
                                        <i class="bi bi-file-earmark-check text-success fs-4 me-2"></i>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="small fw-bold mb-0 text-truncate text-dark">{{ basename($dok->file_path) }}</p>
                                            <p class="extra-small text-muted mb-0">{{ $dok->updated_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="btn btn-sm btn-white shadow-sm rounded-pill ms-2">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                    @if($dok->catatan_verifikator)
                                        <div class="alert alert-danger border-0 rounded-3 p-2 mb-3">
                                            <small><i class="bi bi-info-circle me-1"></i> <b>Revisi:</b> {{ $dok->catatan_verifikator }}</small>
                                        </div>
                                    @endif
                                @endif

                                <button class="btn {{ $dok ? 'btn-outline-'.$s['color'] : 'btn-'.$s['color'] }} w-100 rounded-pill py-2 fw-bold"
                                        data-bs-toggle="modal" data-bs-target="#modal{{ $s['id'] }}">
                                    <i class="bi {{ $dok ? 'bi-arrow-repeat' : 'bi-upload' }} me-2"></i>
                                    {{ $dok ? 'Ganti Berkas' : 'Unggah Berkas' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Upload per Jenis Dokumen --}}
                    <div class="modal fade" id="modal{{ $s['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('klien.dokumen.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
                                @csrf
                                <input type="hidden" name="id_pendaftaran" value="{{ $pendaftaran->id_pendaftaran }}">
                                <input type="hidden" name="nama_dokumen" value="{{ $s['nama'] }}">
                                <div class="modal-header border-0 p-4 pb-0">
                                    <h5 class="fw-bold">Unggah {{ $s['nama'] }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 text-center">
                                    <div class="upload-container border-2 border-dashed rounded-4 p-5 bg-light mb-3" id="dropArea{{ $s['id'] }}">
                                        <i class="bi bi-cloud-arrow-up text-{{ $s['color'] }}" style="font-size: 4rem;"></i>
                                        <h6 class="mt-3 fw-bold">Pilih file atau tarik ke sini</h6>
                                        <p class="extra-small text-muted">Format yang diizinkan: PDF, JPG, PNG (Max 5MB)</p>
                                        <input type="file" name="file_dokumen" class="form-control mt-4 rounded-pill shadow-none" required>
                                    </div>
                                    <p class="extra-small text-start text-muted italic">* Mengunggah file baru akan menggantikan file yang sudah ada sebelumnya.</p>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-{{ $s['color'] }} rounded-pill px-5 fw-bold shadow-sm">Simpan Dokumen</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .icon-shape {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .extra-small { font-size: 0.75rem; }
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.12)!important;
    }
    .border-dashed {
        border-style: dashed !important;
        border-width: 2px !important;
    }
    .btn-white {
        background: white;
        color: #444;
    }
</style>
@endsection
