@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Edit Data Pengguna</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $user->nama_lengkap }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Role / Peran</label>
                            <select name="role" class="form-select" required>
                                <option value="klien" {{ $user->role == 'klien' ? 'selected' : '' }}>Klien</option>
                                <option value="konsultan" {{ $user->role == 'konsultan' ? 'selected' : '' }}>Konsultan</option>
                                <option value="keuangan" {{ $user->role == 'keuangan' ? 'selected' : '' }}>Bagian Keuangan</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4">
                            <label class="form-label fw-bold mb-1">Ganti Password (Opsional)</label>
                            <p class="small text-muted mb-3">Kosongkan jika tidak ingin mengubah password.</p>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="password" name="password" class="form-control" placeholder="Password baru">
                                </div>
                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">Kembali</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Update Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
