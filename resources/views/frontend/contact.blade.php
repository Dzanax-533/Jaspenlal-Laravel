@extends('layouts.frontend')
@section('content')
<section class="py-5 container">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Hubungi Tim Kami</h2>
        <p class="text-muted">Siap melayani konsultasi pendaftaran sertifikasi halal Anda.</p>
    </div>
    <div class="row g-5">
        <div class="col-md-4">
            <div class="p-4 bg-white shadow-sm rounded border-start border-primary border-4">
                <h6 class="fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i> Alamat</h6>
                <p class="small text-muted mb-0">Gedung Halal Center, Jakarta.</p>
            </div>
        </div>
        <div class="col-md-8">
            <form class="card p-4 border-0 shadow-sm">
                <div class="row">
                    <div class="col-md-6 mb-3"><input type="text" class="form-control" placeholder="Nama"></div>
                    <div class="col-md-6 mb-3"><input type="email" class="form-control" placeholder="Email"></div>
                </div>
                <textarea class="form-control mb-3" rows="4" placeholder="Pesan"></textarea>
                <button class="btn btn-primary px-5 shadow-sm">Kirim Pesan</button>
            </form>
        </div>
    </div>
</section>
@endsection
