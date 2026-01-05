@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header Dashboard --}}
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark">Dashboard Administrator</h3>
            <p class="text-muted">Fokus Utama: Manajemen Pengguna & Pembagian Konsultan</p>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4 rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Statistik SDM --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small fw-bold text-uppercase opacity-75">Total Klien</h6>
                            <h2 class="fw-bold mb-0">{{ $stats['total_klien'] ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small fw-bold text-uppercase opacity-75">Total Konsultan</h6>
                            <h2 class="fw-bold mb-0">{{ $stats['total_konsultan'] ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-person-badge fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small fw-bold text-uppercase opacity-75">Staf Keuangan</h6>
                            <h2 class="fw-bold mb-0">{{ $stats['total_keuangan'] ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-person-gear fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Antrean Pembagian Konsultan --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2 text-warning"></i>Antrean Pembagian Konsultan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">Klien</th>
                                    <th>Paket Pilihan</th>
                                    <th>Tanggal Daftar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($antrean_pendaftaran as $daftar)
                                    {{-- Cek apakah ID tersedia sebelum render baris --}}
                                    @if(isset($daftar->id))
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">{{ $daftar->klien->nama_lengkap ?? 'Klien Terhapus' }}</div>
                                            <small class="text-muted">{{ $daftar->klien->email ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                                                {{ $daftar->paket->nama_paket ?? 'Paket N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $daftar->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm"
                                                    data-bs-toggle="modal" data-bs-target="#assignModal{{ $daftar->id }}">
                                                Bagi Konsultan
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Modal Pembagian Konsultan --}}
                                    <div class="modal fade" id="assignModal{{ $daftar->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('admin.assign.konsultan', $daftar->id) }}" method="POST" class="modal-content border-0 shadow rounded-4">
                                                @csrf
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title fw-bold">Tugaskan Konsultan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body py-4">
                                                    <p class="text-muted">Pilih konsultan untuk mendampingi klien:</p>
                                                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                                                        <i class="bi bi-person-circle fs-3 me-3 text-primary"></i>
                                                        <div>
                                                            <div class="fw-bold">{{ $daftar->klien->nama_lengkap ?? 'N/A' }}</div>
                                                            <small>{{ $daftar->paket->nama_paket ?? 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nama Konsultan</label>
                                                        <select name="id_konsultan" class="form-select shadow-sm" required>
                                                            <option value="" disabled selected>-- Pilih Konsultan Tersedia --</option>
                                                            @foreach($konsultans as $k)
                                                                <option value="{{ $k->id }}">{{ $k->nama_lengkap }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Konfirmasi Penugasan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="mb-2">
                                            <i class="bi bi-check2-circle fs-1 text-success"></i>
                                        </div>
                                        <p class="mb-0">Tidak ada antrean pembagian konsultan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: #e7f1ff; }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
</style>
@endsection
