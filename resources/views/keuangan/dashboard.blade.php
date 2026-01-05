@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Dashboard Keuangan</h2>
            <p class="text-muted">Pantau pendapatan dan kelola parameter biaya pendaftaran.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('keuangan.pengaturan.index') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-gear-fill"></i> Atur Parameter Biaya
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small">Total Estimasi Pendapatan</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small text-muted">Pendaftaran Pending</h6>
                    <h2 class="fw-bold mb-0 text-warning">{{ $pendaftaranPending }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small text-muted">Sertifikasi Selesai</h6>
                    <h2 class="fw-bold mb-0 text-success">{{ $pendaftaranSelesai }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Aktivitas Pendaftaran Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Registrasi</th>
                            <th>Klien</th>
                            <th>Paket</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPendaftarans as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->no_pendaftaran }}</td>
                            <td>{{ $item->klien->nama_perusahaan }}</td>
                            <td>{{ $item->paket->nama_paket }}</td>
                            <td class="fw-bold">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $item->status_pendaftaran == 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ strtoupper($item->status_pendaftaran) }}
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada data pendaftaran masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 text-center py-3">
            <a href="#" class="btn btn-sm btn-link text-decoration-none">Lihat Semua Laporan Keuangan</a>
        </div>
    </div>
</div>
@endsection
