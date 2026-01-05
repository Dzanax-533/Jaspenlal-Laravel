@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            {{-- Detail Pendaftaran & Klien --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="fw-bold mb-1">Detail Pendaftaran #{{ $pendaftaran->no_pendaftaran }}</h4>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                Status: {{ strtoupper($pendaftaran->status_pendaftaran) }}
                            </span>
                        </div>
                        <a href="{{ route('keuangan.pendaftaran.index') }}" class="btn btn-light rounded-pill btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Nama Klien / Perusahaan</label>
                            <p class="fw-bold mb-0">{{ $pendaftaran->klien->user->nama_lengkap }}</p>
                            <p class="text-muted small">{{ $pendaftaran->klien->nama_perusahaan }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Paket Terpilih</label>
                            <p class="fw-bold mb-0">{{ $pendaftaran->paket->nama_paket }}</p>
                            <p class="text-success fw-bold small">Harga Dasar: Rp {{ number_format($pendaftaran->paket->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Transaksi Midtrans --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0">Informasi Transaksi Digital (Midtrans)</h6>
                </div>
                <div class="card-body p-4">
                    @if($pendaftaran->pembayaran)
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <tr>
                                    <th class="text-muted small fw-normal ps-0">No. Invoice</th>
                                    <td class="fw-bold text-end">{{ $pendaftaran->pembayaran->no_invoice }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small fw-normal ps-0">Status Pembayaran</th>
                                    <td class="text-end">
                                        @if($pendaftaran->pembayaran->status_pembayaran == 'lunas')
                                            <span class="badge bg-success rounded-pill px-3">Lunas Otomatis</span>
                                        @elseif($pendaftaran->pembayaran->status_pembayaran == 'pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-3">Menunggu Pembayaran</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3">Gagal/Expired</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted small fw-normal ps-0">Metode</th>
                                    <td class="text-end text-uppercase">{{ $pendaftaran->pembayaran->keterangan ?? 'Online Payment' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted small fw-normal ps-0">Waktu Transaksi</th>
                                    <td class="text-end">{{ $pendaftaran->pembayaran->tanggal_verifikasi ? \Carbon\Carbon::parse($pendaftaran->pembayaran->tanggal_verifikasi)->format('d M Y, H:i') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-clock-history fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada data transaksi masuk dari sistem.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Panel Kalkulasi Biaya (Hanya Update Biaya Tambahan) --}}
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Penyesuaian Biaya</h5>

                    <form action="{{ route('keuangan.pendaftaran.update_biaya', $pendaftaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Total Biaya Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">Rp</span>
                                <input type="text" class="form-control bg-light border-0 fw-bold text-primary"
                                       value="{{ number_format($pendaftaran->total_biaya, 0, ',', '.') }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Biaya Tambahan Baru</label>
                            <div class="input-group">
                                <span class="input-group-text border-2">Rp</span>
                                <input type="number" name="total_biaya" class="form-control border-2"
                                       placeholder="Input total biaya akhir..."
                                       @if($pendaftaran->pembayaran && $pendaftaran->pembayaran->status_pembayaran == 'lunas') disabled @endif>
                            </div>
                            <small class="text-muted italic">Biaya tidak dapat diubah jika pembayaran sudah lunas.</small>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 fw-bold shadow mt-3"
                                @if($pendaftaran->pembayaran && $pendaftaran->pembayaran->status_pembayaran == 'lunas') disabled @endif>
                            UPDATE TOTAL BIAYA
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
