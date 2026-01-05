@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Halo, {{ Auth::user()->nama_lengkap }}!</h2>
            <p class="text-muted">Berikut adalah daftar klien yang dalam pendampingan Anda.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Daftar Antrean Pendaftaran</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama Klien</th>
                            <th>Paket</th>
                            <th>Status Pendaftaran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $p)
                        <tr>
                            <td><span class="fw-bold">{{ $p->no_pendaftaran }}</span></td>
                            <td>{{ $p->klien->nama_perusahaan ?? 'N/A' }}</td>
                            <td><span class="badge bg-outline-primary text-primary border border-primary">{{ $p->paket->nama_paket }}</span></td>
                            <td>
                                <span class="badge {{ $p->status_pendaftaran == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ strtoupper($p->status_pendaftaran) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('konsultan.detail', $p->id_pendaftaran) }}" class="btn btn-sm btn-primary px-3">
                                    <i class="bi bi-search"></i> Periksa Dokumen
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="mb-3 opacity-50"><br>
                                Belum ada klien yang ditugaskan kepada Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
