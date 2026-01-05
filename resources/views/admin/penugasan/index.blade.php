@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark">Pembagian Konsultan Pendamping</h3>
        <p class="text-muted">Tugaskan konsultan ke klien yang baru mendaftar jasa sertifikasi.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Antrean --}}
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-primary">Antrean Klien (Belum Ada Pendamping)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Klien & Paket</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-center" style="width: 350px;">Pilih Konsultan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($antrean as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $item->klien->nama_lengkap }}</div>
                                <span class="badge bg-soft-primary text-primary">{{ $item->paket->nama_paket }}</span>
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.penugasan.store', $item->id) }}" method="POST" class="d-flex gap-2 pe-3">
                                    @csrf
                                    <select name="id_konsultan" class="form-select form-select-sm shadow-sm" required>
                                        <option value="" disabled selected>-- Pilih Konsultan --</option>
                                        @foreach($konsultans as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary px-3 shadow-sm">Tugaskan</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="bi bi-emoji-smile fs-2 d-block mb-2"></i>
                                Tidak ada antrean pendaftaran baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: #e7f1ff; }
</style>
@endsection
