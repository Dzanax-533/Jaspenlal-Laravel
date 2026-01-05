@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold m-0">Edit Paket Jasa</h4>
                <a href="{{ route('keuangan.paket.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    {{-- PENTING: Gunakan id_paket dan rute update --}}
                    <form method="POST" action="{{ route('keuangan.paket.update', $paket->id_paket) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Paket</label>
                            <input type="text" class="form-control" name="nama_paket" value="{{ $paket->nama_paket }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3" required>{{ $paket->deskripsi }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" class="form-control" name="harga" value="{{ $paket->harga }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Durasi (Hari)</label>
                                <input type="number" class="form-control" name="durasi_hari" value="{{ $paket->durasi_hari }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Benefit</label>
                            <textarea class="form-control" name="benefit" rows="2" required>{{ $paket->benefit }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status">
                                <option value="aktif" {{ $paket->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ $paket->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="text-end border-top pt-3">
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Update Paket Jasa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection