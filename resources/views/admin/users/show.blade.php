@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Informasi Detail Pengguna</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light border">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-placeholder bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                        </div>
                        <h4 class="mb-0">{{ $user->nama_lengkap }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>

                    <ul class="list-group list-group-flush border-top">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted small text-uppercase fw-bold">ID Pengguna</span>
                            <span>#{{ $user->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted small text-uppercase fw-bold">Hak Akses</span>
                            <span class="badge bg-primary px-3">{{ strtoupper($user->role) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted small text-uppercase fw-bold">Tanggal Bergabung</span>
                            <span>{{ $user->created_at->format('d M Y, H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted small text-uppercase fw-bold">Terakhir Diperbarui</span>
                            <span>{{ $user->updated_at->diffForHumans() }}</span>
                        </li>
                    </ul>

                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary px-4">
                            <i class="bi bi-pencil-square me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
