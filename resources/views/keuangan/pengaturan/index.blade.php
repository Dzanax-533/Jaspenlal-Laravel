@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="fw-bold text-dark mb-1">Konfigurasi Biaya Perusahaan</h3>
            <p class="text-muted">Kelola parameter biaya registrasi dan administrasi yang akan dibebankan kepada klien.</p>
        </div>
        <div class="col-md-4 text-md-end pt-2">
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#tambahBiaya">
                <i class="bi bi-plus-circle me-2"></i>Tambah Parameter Baru
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 ps-4">
            <h5 class="fw-bold mb-0 mt-1">Daftar Parameter Aktif</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3 border-0">Detail Parameter</th>
                        <th class="py-3 border-0">Nominal Biaya</th>
                        <th class="py-3 border-0">Status Sistem</th>
                        <th class="py-3 border-0">Update Terakhir</th>
                        <th class="text-center py-3 border-0 pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaturan_biaya as $pb)
                    <tr class="border-top border-light">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="bi bi-gear-fill text-secondary"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ strtoupper(str_replace('_', ' ', $pb->key)) }}</div>
                                    <small class="text-muted small">Diterapkan pada setiap pendaftaran klien baru.</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-primary fs-6">Rp {{ number_format($pb->value, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                <i class="bi bi-check-circle-fill me-1"></i> Aktif
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $pb->updated_at->format('d M Y, H:i') }}</small>
                        </td>
                        <td class="text-center pe-4">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                <button class="btn btn-white btn-sm px-3 border-end" title="Edit Data" data-bs-toggle="modal" data-bs-target="#editModal{{ $pb->id }}">
                                    <i class="bi bi-pencil-square text-warning"></i>
                                </button>
                                <button class="btn btn-white btn-sm px-3" title="Hapus Parameter">
                                    <i class="bi bi-trash3 text-danger"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-database-dash display-4 text-muted opacity-25 d-block mb-3"></i>
                            <p class="text-muted fw-medium">Belum ada parameter biaya yang dikonfigurasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection