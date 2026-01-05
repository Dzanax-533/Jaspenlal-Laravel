@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Laporan Transaksi Klien</h3>
            <p class="text-muted small">Monitoring status pembayaran otomatis (Midtrans) dan penyesuaian biaya pendaftaran.</p>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No. Pendaftaran</th>
                        <th>Klien / Perusahaan</th>
                        <th>Paket & Skala</th>
                        <th>Status Pembayaran</th>
                        <th>Metode</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftarans as $p)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">{{ $p->no_pendaftaran }}</td>
                        <td>
                            <div class="fw-bold">{{ $p->klien->user->nama_lengkap ?? 'N/A' }}</div>
                            <div class="text-muted small">{{ $p->klien->nama_perusahaan ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="badge bg-info bg-opacity-10 text-info border-info border mb-1">
                                {{ $p->paket->nama_paket ?? 'N/A' }}
                            </div>
                            <div class="small text-muted">{{ strtoupper($p->skala_usaha) }}</div>
                        </td>
                        <td>
                            @if($p->pembayaran)
                                <span class="badge bg-{{ $p->pembayaran->status_pembayaran == 'lunas' ? 'success' : ($p->pembayaran->status_pembayaran == 'pending' ? 'warning' : 'danger') }} rounded-pill px-3">
                                    <i class="bi bi-circle-fill me-1 small"></i>
                                    {{ strtoupper($p->pembayaran->status_pembayaran) }}
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3 text-white">MENUNGGU TAGIHAN</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ $p->pembayaran->keterangan ?? 'Online Payment' }}
                        </td>
                        <td class="text-center">
                            {{-- PERBAIKAN: Menggunakan id_pendaftaran sebagai parameter --}}
                            <a href="{{ route('keuangan.pendaftaran.show', $p->id_pendaftaran) }}" class="btn btn-sm btn-dark rounded-pill px-4 shadow-sm">
                                <i class="bi bi-eye me-1"></i> Detail & Biaya
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if($pendaftarans->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                            Tidak ada transaksi pendaftaran yang ditemukan.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding-top: 15px;
        padding-bottom: 15px;
        color: #6c757d;
    }
    .badge {
        font-weight: 600;
        font-size: 0.75rem;
        padding: 0.5em 1em;
    }
    .btn-dark {
        background-color: #2d3436;
        border: none;
    }
    .btn-dark:hover {
        background-color: #000;
    }
</style>
@endsection
