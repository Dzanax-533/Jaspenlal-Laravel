@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Manajemen Pengguna</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm rounded-3">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role / Hak Akses</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $user->nama_lengkap }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                {{-- Logika Pewarnaan Badge Berdasarkan Role --}}
                                @php
                                    $badgeClass = 'bg-secondary';
                                    if($user->role == 'admin') $badgeClass = 'bg-danger';
                                    elseif($user->role == 'keuangan') $badgeClass = 'bg-dark';
                                    elseif($user->role == 'konsultan') $badgeClass = 'bg-success';
                                    elseif($user->role == 'klien') $badgeClass = 'bg-info text-dark';
                                @endphp
                                <span class="badge {{ $badgeClass }} text-uppercase px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm rounded-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-white border" title="Lihat Detail">
                                        <i class="bi bi-eye text-secondary"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-white border" title="Ubah Data">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white border" title="Hapus User">
                                            <i class="bi bi-trash3 text-danger"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tambahan style agar tabel terlihat lebih bersih */
    .table thead th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6c757d;
    }
    .btn-white {
        background-color: #fff;
    }
    .btn-white:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
