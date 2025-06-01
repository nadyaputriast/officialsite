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
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\KomentarPortofolioController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PembayaranEventInternalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;

Route::view('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/profile', [ProfileController::class, 'ownProfile'])
    ->middleware(['auth'])
    ->name('profile');

Route::get('/profile/{id}', [ProfileController::class, 'show'])
    ->middleware(['auth'])
    ->name('profile.user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
    
Route::middleware(['auth'])->group(function () {
    Route::get('/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio.create');
    Route::get('/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');
    Route::post('/portofolio', [PortofolioController::class, 'store'])->name('portofolio.store');
    Route::get('/portofolio/{id}', [PortofolioController::class, 'show'])->name('portofolio.show');
    Route::put('/portofolio/{id}', [PortofolioController::class, 'update'])->name('portofolio.update');
    Route::get('/portofolio/{id}/edit', [PortofolioController::class, 'edit'])->name('portofolio.edit');
    Route::delete('/portofolio/{id}', [PortofolioController::class, 'destroy'])->name('portofolio.destroy');
    Route::post('/portofolio/{id}/upvote', [PortofolioController::class, 'upvote'])->name('portofolio.upvote');
    Route::post('/portofolio/{id}/downvote', [PortofolioController::class, 'downvote'])->name('portofolio.downvote');
    Route::post('portofolio/{id}/komentar', [PortofolioController::class, 'komentar'])->name('portofolio.komentar');
    
    Route::get('/oprek', [OprekProjectController::class, 'create'])->name('oprek.create');
    Route::post('/oprek', [OprekProjectController::class, 'store'])->name('oprek.store');
    Route::get('/oprek/{id}', [OprekProjectController::class, 'show'])->name('oprek.show');
    Route::put('/oprek/{id}', [OprekProjectController::class, 'update'])->name('oprek.update');
    Route::get('/oprek/{id}/edit', [OprekProjectController::class, 'edit'])->name('oprek.edit');
    Route::post('oprek/{id}/komentar', [OprekProjectController::class, 'komentar'])->name('oprek.komentar');

    Route::get('/prestasi', [PrestasiController::class, 'create'])->name('prestasi.create');
    Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::get('/prestasi/{id}', [PrestasiController::class, 'show'])->name('prestasi.show');
    Route::put('/prestasi/{id}', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::get('/prestasi/{id}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit');
    Route::post('prestasi/{id}/komentar', [PrestasiController::class, 'komentar'])->name('prestasi.komentar');

    Route::get('/pengabdian', [PengabdianController::class, 'create'])->name('pengabdian.create');
    Route::post('/pengabdian', [PengabdianController::class, 'store'])->name('pengabdian.store');
    Route::get('/pengabdian/{id}', [PengabdianController::class, 'show'])->name('pengabdian.show');
    Route::put('/pengabdian/{id}', [PengabdianController::class, 'update'])->name('pengabdian.update');
    Route::get('/pengabdian/{id}/edit', [PengabdianController::class, 'edit'])->name('pengabdian.edit');
    Route::post('pengabdian/{id}/komentar', [PengabdianController::class, 'komentar'])->name('pengabdian.komentar');

    Route::get('/sertifikasi', [SertifikasiController::class, 'create'])->name('sertifikasi.create');
    Route::post('/sertifikasi', [SertifikasiController::class, 'store'])->name('sertifikasi.store');
    Route::get('/sertifikasi/{id}', [SertifikasiController::class, 'show'])->name('sertifikasi.show');
    Route::put('/sertifikasi/{id}', [SertifikasiController::class, 'update'])->name('sertifikasi.update');
    Route::get('/sertifikasi/{id}/edit', [SertifikasiController::class, 'edit'])->name('sertifikasi.edit');
    Route::post('sertifikasi/{id}/komentar', [SertifikasiController::class, 'komentar'])->name('sertifikasi.komentar');

    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{id_event}', [EventController::class, 'show'])->name('event.show');
    Route::get('/event/{id_event}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/{id_event}', [EventController::class, 'update'])->name('event.update');
    Route::post('event/{id}/komentar', [EventController::class, 'komentar'])->name('event.komentar');
    Route::get('/event/{id}', [EventRegistrationController::class, 'show'])->name('event.show');
    Route::get('/event/{id}/register', [EventRegistrationController::class, 'register'])->name('event.register');
    Route::post('/event/{id}/register', [EventRegistrationController::class, 'store'])->name('event.register.store');
    Route::get('/cek-promo', [EventRegistrationController::class, 'cekPromo']);
    Route::get('/download/create', [DownloadController::class, 'create'])->name('download.create');
    Route::post('/download', [DownloadController::class, 'store'])->name('download.store');
    Route::get('/download/{id}/edit', [DownloadController::class, 'edit'])->name('download.edit');
    Route::put('/download/{id}', [DownloadController::class, 'update'])->name('download.update');
    Route::get('/download/{id}', [DownloadController::class, 'show'])->name('download.show');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
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
    Route::post('/download/{id}/validate', [DownloadController::class, 'validateDownload'])->name('download.validate');
    Route::post('/pembayaran/{id}/validasi', [PembayaranEventInternalController::class, 'validasi'])->name('pembayaran.validasi');
    Route::post('/user/validate/{id}', [UserController::class, 'validateUser'])->name('user.validate');
});


require __DIR__ . '/auth.php';
