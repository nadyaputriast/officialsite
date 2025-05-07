<?php

use App\Http\Controllers\AdminPortofolioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\DashboardAdminController;
// use App\Http\Controllers\DashboardMahasiswaController;
// use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\OprekProjectController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KomentarPortofolioController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\SertifikasiController;

Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio.create');
    Route::post('/portofolio', [PortofolioController::class, 'store'])->name('portofolio.store');
    Route::get('/portofolio/{id}', [PortofolioController::class, 'show'])->name('portofolio.show');
    Route::put('/portofolio/{id}', [PortofolioController::class, 'update'])->name('portofolio.update');
    Route::get('/portofolio/{id}/edit', [PortofolioController::class, 'edit'])->name('portofolio.edit');
    Route::post('/portofolio/{id}/upvote', [PortofolioController::class, 'upvote'])->name('portofolio.upvote');
    Route::post('/portofolio/{id}/downvote', [PortofolioController::class, 'downvote'])->name('portofolio.downvote');
    
    Route::get('/oprek', [OprekProjectController::class, 'create'])->name('oprek.create');
    Route::post('/oprek', [OprekProjectController::class, 'store'])->name('oprek.store');
    Route::get('/oprek/{id}', [OprekProjectController::class, 'show'])->name('oprek.show');
    Route::put('/oprek/{id}', [OprekProjectController::class, 'update'])->name('oprek.update');
    Route::get('/oprek/{id}/edit', [OprekProjectController::class, 'edit'])->name('oprek.edit');

    Route::get('/prestasi', [PrestasiController::class, 'create'])->name('prestasi.create');
    Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::get('/prestasi/{id}', [PrestasiController::class, 'show'])->name('prestasi.show');
    Route::put('/prestasi/{id}', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::get('/prestasi/{id}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit');

    Route::get('/pengabdian', [PengabdianController::class, 'create'])->name('pengabdian.create');
    Route::post('/pengabdian', [PengabdianController::class, 'store'])->name('pengabdian.store');
    Route::get('/pengabdian/{id}', [PengabdianController::class, 'show'])->name('pengabdian.show');
    Route::put('/pengabdian/{id}', [PengabdianController::class, 'update'])->name('pengabdian.update');
    Route::get('/pengabdian/{id}/edit', [PengabdianController::class, 'edit'])->name('pengabdian.edit');

    Route::get('/sertifikasi', [SertifikasiController::class, 'create'])->name('sertifikasi.create');
    Route::post('/sertifikasi', [SertifikasiController::class, 'store'])->name('sertifikasi.store');
    Route::get('/sertifikasi/{id}', [SertifikasiController::class, 'show'])->name('sertifikasi.show');
    Route::put('/sertifikasi/{id}', [SertifikasiController::class, 'update'])->name('sertifikasi.update');
    Route::get('/sertifikasi/{id}/edit', [SertifikasiController::class, 'edit'])->name('sertifikasi.edit');

    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{id_event}', [EventController::class, 'show'])->name('event.show');
    Route::get('/event/{id_event}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/{id_event}', [EventController::class, 'update'])->name('event.update');
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/portofolio', [AdminPortofolioController::class, 'index'])->name('admin.portofolio.index');
//     Route::post('/admin/portofolio/{id}/approve', [AdminPortofolioController::class, 'approve'])->name('admin.portofolio.approve');
//     Route::post('/admin/portofolio/{id}/reject', [AdminPortofolioController::class, 'reject'])->name('admin.portofolio.reject');
// });

Route::prefix('portofolio/{id_portofolio}/komentar')->group(function () {
    Route::get('/', [KomentarPortofolioController::class, 'index'])->name('komentar.index');
    Route::post('/', [KomentarPortofolioController::class, 'store'])->name('komentar.store');
    Route::get('/{id_komentar}', [KomentarPortofolioController::class, 'show'])->name('komentar.show');
    Route::put('/{id_komentar}', [KomentarPortofolioController::class, 'update'])->name('komentar.update');
    Route::delete('/{id_komentar}', [KomentarPortofolioController::class, 'destroy'])->name('komentar.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/oprek/{id}/validate', [OprekProjectController::class, 'validateProject'])->name('oprek.validate');
    Route::post('/portofolio/{id}/validate', [PortofolioController::class, 'validatePortofolio'])->name('portofolio.validate');
    Route::post('/prestasi/{id}/validate', [PrestasiController::class, 'validatePrestasi'])->name('prestasi.validate');
    Route::post('pengabdian/{id}/validate', [PengabdianController::class, 'validatePengabdian'])->name('pengabdian.validate');
    Route::post('/sertifikasi/{id}/validate', [SertifikasiController::class, 'validateSertifikasi'])->name('sertifikasi.validate');
    Route::post('/event/{id_event}/validate', [EventController::class, 'validateEvent'])->name('event.validate');
});


require __DIR__ . '/auth.php';
