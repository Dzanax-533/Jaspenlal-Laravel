@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            {{-- Header --}}
            <div class="mb-4 d-flex align-items-center">
                <a href="{{ route('klien.pendaftaran.daftar') }}" class="btn btn-outline-primary border-0 rounded-circle me-3">
                    <i class="bi bi-arrow-left fs-4"></i>
                </a>
                <div>
                    <h3 class="fw-bold mb-0 text-dark">Formulir Pendaftaran Sertifikasi</h3>
                    <p class="text-muted mb-0">Paket: <span class="badge bg-primary bg-opacity-10 text-primary">{{ $paket->nama_paket }}</span></p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <form action="{{ route('klien.pendaftaran.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_paket" value="{{ $paket->id_paket }}">

                            {{-- INPUT HIDDEN UNTUK TOTAL BIAYA HASIL KALKULASI JS --}}
                            <input type="hidden" name="total_biaya_hidden" id="total_biaya_hidden" value="0">

                            {{-- SKALA USAHA --}}
                            <div class="mb-4">
                                <label class="fw-bold form-label text-primary small text-uppercase">Skala Usaha</label>
                                <div class="input-group border-2 border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-primary text-white border-0"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control bg-light border-0 fw-bold" value="Skala {{ ucfirst($paket->skala_usaha) }}" readonly>
                                    <input type="hidden" name="skala_usaha" value="{{ $paket->skala_usaha }}">
                                </div>
                            </div>

                            {{-- MENU TAMBAHAN --}}
                            <div class="mb-4">
                                <label class="fw-bold form-label">Jumlah Tambahan Menu (>50)</label>
                                <div class="input-group border-2 border rounded-3 overflow-hidden">
                                    <input type="number" name="menu_tambahan" id="menu_tambahan" class="form-control border-0" value="0" min="0">
                                    <span class="input-group-text bg-light border-0 small">Menu</span>
                                </div>
                            </div>

                            {{-- OUTLET TAMBAHAN --}}
                            <div class="mb-4">
                                <label class="fw-bold form-label">Jumlah Outlet Tambahan</label>
                                <div class="input-group border-2 border rounded-3 overflow-hidden">
                                    <input type="number" name="outlet_tambahan" id="outlet_tambahan" class="form-control border-0" value="0" min="0">
                                    <span class="input-group-text bg-light border-0 small">Outlet</span>
                                </div>
                            </div>

                            {{-- LOKASI --}}
                            <div class="mb-4">
                                <label class="fw-bold form-label">Lokasi Operasional</label>
                                <select name="lokasi" id="lokasi" class="form-select border-2" required>
                                    <option value="jabodetabek">Dalam Jabodetabek (Include Biaya)</option>
                                    <option value="luar_jabodetabek">Luar Jabodetabek (Akomodasi Ditanggung Klien)</option>
                                </select>
                            </div>

                            {{-- ALAMAT --}}
                            <div class="mb-4">
                                <label class="fw-bold form-label">Alamat Lengkap Produksi</label>
                                <textarea name="catatan" class="form-control border-2" rows="3" placeholder="Masukkan alamat lengkap..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                                <i class="bi bi-wallet2 me-2"></i>Daftar & Bayar Termin 1 (DP)
                            </button>
                        </form>
                    </div>
                </div>

                {{-- RINGKASAN BIAYA --}}
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4 sticky-top" style="top: 20px;">
                        <h5 class="fw-bold text-primary mb-4">Skema Pembayaran 2 Termin</h5>

                        <div class="small text-white-50 mb-3">Rincian Kalkulasi:</div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50 small">Harga Dasar Paket</span>
                            <span id="live_dasar" class="fw-bold text-white small">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50 small">Tambahan Menu</span>
                            <span id="live_menu" class="fw-bold text-white small">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-white-50 small">Tambahan Outlet</span>
                            <span id="live_outlet" class="fw-bold text-white small">Rp 0</span>
                        </div>

                        <hr class="border-secondary opacity-25">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">Total Biaya Jasa</span>
                            <span class="h4 mb-0 fw-bold text-white" id="live_total">Rp 0</span>
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-4 border border-primary border-opacity-25 text-center">
                                    <small class="text-primary d-block mb-1 fw-bold">TERMIN 1 (50%)</small>
                                    <h5 class="mb-0 fw-bold" id="live_t1">Rp 0</h5>
                                    <small class="extra-small text-white-50">Bayar Sekarang</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-secondary bg-opacity-10 p-3 rounded-4 border border-secondary border-opacity-25 text-center opacity-75">
                                    <small class="text-secondary d-block mb-1 fw-bold">TERMIN 2 (50%)</small>
                                    <h5 class="mb-0 fw-bold" id="live_t2">Rp 0</h5>
                                    <small class="extra-small text-white-50">Saat Sertifikat Terbit</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function updateLiveCalculation() {
            let hargaDasar = {{ $paket->harga ?? 0 }};
            let skala = "{{ $paket->skala_usaha ?? 'kecil' }}";
            let menuTambahan = parseInt($('#menu_tambahan').val()) || 0;
            let outletTambahan = parseInt($('#outlet_tambahan').val()) || 0;

            let tarifPer30 = (skala === 'kecil') ? 500000 : (skala === 'menengah' ? 1000000 : 1500000);
            let biayaMenu = (menuTambahan > 0) ? Math.ceil(menuTambahan / 30) * tarifPer30 : 0;
            let biayaOutlet = outletTambahan * 1500000;

            let total = hargaDasar + biayaMenu + biayaOutlet;
            let termin = total / 2;

            // Update UI
            $('#live_dasar').text('Rp ' + hargaDasar.toLocaleString('id-ID'));
            $('#live_menu').text('Rp ' + biayaMenu.toLocaleString('id-ID'));
            $('#live_outlet').text('Rp ' + biayaOutlet.toLocaleString('id-ID'));
            $('#live_total').text('Rp ' + total.toLocaleString('id-ID'));
            $('#live_t1').text('Rp ' + termin.toLocaleString('id-ID'));
            $('#live_t2').text('Rp ' + termin.toLocaleString('id-ID'));

            // SINKRONISASI: Masukkan angka total ke input hidden agar terkirim ke Controller
            $('#total_biaya_hidden').val(total);
        }

        updateLiveCalculation();
        $('#menu_tambahan, #outlet_tambahan, #lokasi').on('input change keyup', function() {
            updateLiveCalculation();
        });
    });
</script>
@endsection
