@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">{{ __('Daftar Akun Baru') }}</h3>
                        <p class="text-muted small">Bergabunglah dengan kami untuk memulai proses sertifikasi halal Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label small fw-bold text-muted">{{ __('Username') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-badge text-muted"></i></span>
                                    <input id="username" type="text" class="form-control bg-light border-start-0 @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="username123">
                                </div>
                                @error('username')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label small fw-bold text-muted">{{ __('Nama Lengkap') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input id="nama_lengkap" type="text" class="form-control bg-light border-start-0 @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required autocomplete="name" placeholder="Nama Sesuai Identitas">
                                </div>
                                @error('nama_lengkap')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label small fw-bold text-muted">{{ __('Alamat Email') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input id="email" type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="contoh@email.com">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="no_telepon" class="form-label small fw-bold text-muted">{{ __('No. Telepon') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-whatsapp text-muted"></i></span>
                                    <input id="no_telepon" type="text" class="form-control bg-light border-start-0 @error('no_telepon') is-invalid @enderror" name="no_telepon" value="{{ old('no_telepon') }}" required placeholder="0812xxxxxx">
                                </div>
                                @error('no_telepon')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label small fw-bold text-muted">{{ __('Kata Sandi') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input id="password" type="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password-confirm" class="form-label small fw-bold text-muted">{{ __('Konfirmasi Sandi') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-check text-muted"></i></span>
                                    <input id="password-confirm" type="password" class="form-control bg-light border-start-0" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                                {{ __('Daftar Sekarang') }}
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="small text-muted mb-0">Sudah memiliki akun?
                                <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Login di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling konsisten dengan halaman Login */
    .input-group-text {
        border: 1px solid #ced4da;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    .card {
        animation: slideUp 0.6s ease-out;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3) !important;
    }
</style>
@endsection
