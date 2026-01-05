@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold m-0">Tambah Paket Jasa</h4>
                <a href="{{ route('keuangan.paket.index') }}" class="btn btn-sm btn-outline-secondary">
                    Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('keuangan.paket.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Paket</label>
                            <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" 
                                name="nama_paket" value="{{ old('nama_paket') }}" required>
                            @error('nama_paket')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" class="form-control" name="harga" value="{{ old('harga') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Durasi (Hari)</label>
                                <input type="number" class="form-control" name="durasi_hari" value="{{ old('durasi_hari') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Benefit</label>
                            <textarea class="form-control" name="benefit" rows="2" placeholder="Pisahkan dengan koma..." required>{{ old('benefit') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status">
                                <option value="aktif">Aktif</option>
                                <option value="tidak_aktif">Tidak Aktif</option>
                            </select>
                        </div>

                        <hr>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                Simpan Paket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection