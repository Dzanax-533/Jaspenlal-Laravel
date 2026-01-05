@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('konsultan.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Detail Pendaftaran</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark">Pemeriksaan Dokumen: {{ $pendaftaran->no_pendaftaran }}</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form Update Progres Gabungan --}}
    <div class="card shadow-sm mb-4 border-primary">
        <div class="card-body">
            <form action="{{ route('konsultan.progres.update', $pendaftaran->id_pendaftaran) }}" method="POST">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Status Saat Ini:</h6>
                        <span class="badge bg-info fs-6 text-dark">{{ strtoupper($pendaftaran->status_pendaftaran) }}</span>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold small">Update Step (1-6):</span>
                            <select name="step_ke" class="form-select form-select-sm" required>
                                @php
                                    $steps = [
                                        1 => '1. Persiapan',
                                        2 => '2. Pendaftaran',
                                        3 => '3. Pembayaran',
                                        4 => '4. Verifikasi',
                                        5 => '5. Pendampingan',
                                        6 => '6. Selesai'
                                    ];
                                    /**
                                     * MENGGUNAKAN 'tahap_progres'
                                     * Sesuai dengan kolom di database Anda agar dropdown sinkron
                                     */
                                    $latestData = $pendaftaran->progres()->latest()->first();
                                    $currentStepFromDB = $latestData ? $latestData->tahap_progres : 1;
                                @endphp
                                @foreach($steps as $num => $label)
                                    <option value="{{ $num }}" {{ $currentStepFromDB == $num ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>

                            <span class="input-group-text bg-light fw-bold small">Status Akhir:</span>
                            <select name="status_pendaftaran" class="form-select form-select-sm">
                                <option value="pending" {{ $pendaftaran->status_pendaftaran == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diproses" {{ $pendaftaran->status_pendaftaran == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pendaftaran->status_pendaftaran == 'selesai' ? 'selected' : '' }}>Selesai (Lulus)</option>
                                <option value="dibatalkan" {{ $pendaftaran->status_pendaftaran == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">Update Progres</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        {{-- Profil Perusahaan --}}
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 border-0 rounded-3">
                <div class="card-header bg-dark text-white fw-bold">Profil Perusahaan</div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 110px;">Perusahaan</td>
                            <td>: <strong>{{ $pendaftaran->klien->nama_perusahaan }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Pemilik</td>
                            <td>: {{ $pendaftaran->klien->nama_pemilik }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Paket</td>
                            <td>: <span class="badge bg-primary">{{ $pendaftaran->paket->nama_paket }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tgl Daftar</td>
                            <td>: {{ date('d M Y', strtotime($pendaftaran->tanggal_pendaftaran)) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Daftar Dokumen --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
                    <span>Daftar Dokumen Terunggah</span>
                    <i class="bi bi-file-earmark-text text-muted"></i>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Dokumen</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftaran->dokumen as $doc)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $doc->nama_dokumen }}</span><br>
                                        <small class="text-muted">Diunggah: {{ date('d/m/Y H:i', strtotime($doc->tanggal_upload)) }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge {{ $doc->status_validasi == 'pending' ? 'bg-warning text-dark' : ($doc->status_validasi == 'disetujui' ? 'bg-success' : 'bg-danger') }}">
                                            {{ strtoupper($doc->status_validasi) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#modalVerif{{ $doc->id_dokumen }}">
                                            Verifikasi
                                        </button>

                                        {{-- Modal Verifikasi Dokumen --}}
                                        <div class="modal fade" id="modalVerif{{ $doc->id_dokumen }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('konsultan.dokumen.verifikasi') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_dokumen" value="{{ $doc->id_dokumen }}">
                                                    <div class="modal-content text-start">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fw-bold">Verifikasi: {{ $doc->nama_dokumen }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Tentukan Status</label>
                                                                <select name="status" class="form-select" required>
                                                                    <option value="disetujui" {{ $doc->status_validasi == 'disetujui' ? 'selected' : '' }}>Setujui Dokumen</option>
                                                                    <option value="ditolak" {{ $doc->status_validasi == 'ditolak' ? 'selected' : '' }}>Tolak / Butuh Perbaikan</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Catatan untuk Klien</label>
                                                                <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Dokumen kurang jelas atau masa berlaku habis...">{{ $doc->keterangan }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary fw-bold">Simpan Verifikasi</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">Klien belum mengunggah dokumen apapun.</td>
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
