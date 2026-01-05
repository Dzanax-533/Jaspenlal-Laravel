@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Matriks Bahan</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm mb-4 border-0 rounded-4">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Bahan Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('klien.bahan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_pendaftaran" value="{{ $pendaftaran->id }}">

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Bahan</label>
                            <input type="text" name="nama_bahan" class="form-control rounded-3" placeholder="Contoh: Tepung Terigu" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Produsen/Merk</label>
                            <input type="text" name="produsen" class="form-control rounded-3" placeholder="Contoh: PT. Bogasari" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">No. Sertifikat Halal</label>
                            <input type="text" name="no_sertifikat_halal" class="form-control rounded-3" placeholder="ID0011xxx">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                            <i class="bi bi-plus-circle me-1"></i> Simpan Bahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm mb-4 border-0 rounded-4">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Bahan Digunakan</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nama Bahan</th>
                                    <th>Produsen</th>
                                    <th>No. Sertifikat</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bahans as $b)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $b->nama_bahan }}</td>
                                    <td>{{ $b->produsen }}</td>
                                    <td><small class="text-muted">{{ $b->no_sertifikat_halal ?? '-' }}</small></td>
                                    <td>
                                        <span class="badge {{ $b->status_bahan == 'layak' ? 'bg-success' : ($b->status_bahan == 'pending' ? 'bg-warning text-dark' : 'bg-danger text-white') }} rounded-pill px-3">
                                            {{ strtoupper($b->status_bahan) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('klien.bahan.hapus', $b->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus bahan ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada bahan yang diinputkan.</td>
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
@endsection
