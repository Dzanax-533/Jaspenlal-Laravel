<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Import Controller Umum
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentCallbackController; // Controller Baru untuk Midtrans

// Import Controller Berdasarkan Namespace Role
use App\Http\Controllers\Klien\DashboardController as KlienDashboard;
use App\Http\Controllers\Klien\PendaftaranController as KlienPendaftaran;
use App\Http\Controllers\Klien\DokumenController as KlienDokumen;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\PenugasanController as AdminPenugasan;

use App\Http\Controllers\Keuangan\DashboardController as KeuanganDashboard;
use App\Http\Controllers\Keuangan\PaketController as KeuanganPaket;
use App\Http\Controllers\Keuangan\PengaturanBiayaController as KeuanganBiaya;
use App\Http\Controllers\Keuangan\PendaftaranController as KeuanganPendaftaran;

use App\Http\Controllers\Konsultan\DashboardController as KonsultanDashboard;

// ==========================
// RUTE UMUM / PUBLIC
// ==========================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/about', [WelcomeController::class, 'about'])->name('about');
Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

/**
 * WEBHOOK MIDTRANS
 * Diletakkan di luar middleware 'auth' karena diakses oleh server Midtrans.
 * Pastikan rute ini didaftarkan di VerifyCsrfToken atau bootstrap/app.php
 */
Route::post('/midtrans-callback', [PaymentCallbackController::class, 'handle'])->name('midtrans.callback');


// ==========================
// ROLE: ADMIN
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUser::class);

    // Penugasan via Dashboard & Menu Khusus
    Route::get('/penugasan', [AdminPenugasan::class, 'index'])->name('penugasan.index');
    Route::post('/penugasan/{id}', [AdminPenugasan::class, 'store'])->name('penugasan.store');
    Route::post('/assign-konsultan/{id}', [AdminDashboard::class, 'assignKonsultan'])->name('assign.konsultan');
});

// ==========================
// ROLE: KEUANGAN
// ==========================
Route::middleware(['auth', 'role:keuangan'])->prefix('keuangan')->as('keuangan.')->group(function () {
    Route::get('/dashboard', [KeuanganDashboard::class, 'index'])->name('dashboard');
    Route::resource('paket', KeuanganPaket::class);

    Route::get('/pengaturan-biaya', [KeuanganBiaya::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan-biaya', [KeuanganBiaya::class, 'update'])->name('pengaturan.update');

    // Fitur Monitoring Pendaftaran (Verifikasi Manual Dihapus)
    Route::get('/pendaftaran', [KeuanganPendaftaran::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}', [KeuanganPendaftaran::class, 'show'])->name('pendaftaran.show');
    Route::put('/pendaftaran/{id}/update-biaya', [KeuanganPendaftaran::class, 'update_biaya'])->name('pendaftaran.update_biaya');

    // Rute Verifikasi Manual dihapus karena sudah otomatis via Midtrans
});

// ==========================
// ROLE: KLIEN
// ==========================
Route::middleware(['auth', 'role:klien'])->prefix('klien')->as('klien.')->group(function () {
    Route::get('/dashboard', [KlienDashboard::class, 'index'])->name('dashboard');
    Route::get('/download-sertifikat/{id}', [KlienDashboard::class, 'downloadSertifikat'])->name('sertifikat.download');

    // Pendaftaran
    Route::get('/riwayat-pendaftaran', [KlienPendaftaran::class, 'index'])->name('pendaftaran.index');
    Route::get('/daftar-paket', [KlienPendaftaran::class, 'listPaket'])->name('pendaftaran.daftar');
    Route::get('/form-pendaftaran/{id}', [KlienPendaftaran::class, 'create'])->name('pendaftaran.create');
    Route::post('/simpan-pendaftaran', [KlienPendaftaran::class, 'store'])->name('pendaftaran.store');
    Route::get('/detail-pendaftaran/{id}', [KlienPendaftaran::class, 'show'])->name('pendaftaran.show');

    // Dokumen & Bahan
    Route::get('/dokumen', [KlienDashboard::class, 'dokumen'])->name('dokumen.index');
    Route::post('/dokumen/store', [KlienDashboard::class, 'storeDokumen'])->name('dokumen.store');
    Route::get('/bahan', [KlienDashboard::class, 'bahan'])->name('bahan.index');
    Route::post('/bahan/store', [KlienDashboard::class, 'storeBahan'])->name('bahan.store');
    Route::delete('/bahan/hapus/{id}', [KlienDashboard::class, 'hapusBahan'])->name('bahan.hapus');

    // Pembayaran Midtrans
    Route::get('/pembayaran', [KlienDashboard::class, 'indexPembayaran'])->name('pembayaran.index');
    Route::get('/pembayaran/form/{id}', [KlienDashboard::class, 'formPembayaran'])->name('pembayaran.form');
});

// ==========================
// ROLE: KONSULTAN
// ==========================
Route::middleware(['auth', 'role:konsultan'])->prefix('konsultan')->as('konsultan.')->group(function () {
    Route::get('/dashboard', [KonsultanDashboard::class, 'index'])->name('dashboard');
    Route::get('/pendaftaran/{id}', [KonsultanDashboard::class, 'detail'])->name('detail');
    Route::post('/pendaftaran/{id}/progres', [KonsultanDashboard::class, 'updateProgres'])->name('progres.update');
    Route::post('/dokumen/verifikasi', [KlienDokumen::class, 'verifikasi'])->name('dokumen.verifikasi');
});
