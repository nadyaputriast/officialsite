<?php

use App\Http\Controllers\AdminPortofolioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\KomentarPortofolioController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\OprekProjectController;
use App\Http\Controllers\PembayaranEventInternalController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\ValidasiUser;
use App\Models\OprekLokerProject;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

Route::get('/waiting-validation', function () {
    return view('auth.waiting_validation');
})->name('user.waiting')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', ValidasiUser::class])
    ->name('dashboard');

Route::post('/dashboard/user/validasi/{user}', [DashboardController::class, 'validasiUser'])
    ->name('user.validasi')
    ->middleware('role:admin');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'ownProfile'])->name('profile');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.user');
});

/*
|--------------------------------------------------------------------------
| Portofolio Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('portofolio')->name('portofolio.')->group(function () {
    Route::get('/', [PortofolioController::class, 'index'])->name('index');
    Route::get('/create', [PortofolioController::class, 'create'])->name('create');
    Route::post('/', [PortofolioController::class, 'store'])->name('store');
    Route::get('/{id}', [PortofolioController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PortofolioController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PortofolioController::class, 'update'])->name('update');
    Route::delete('/{id}', [PortofolioController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/upvote', [PortofolioController::class, 'upvote'])->name('upvote');
    Route::post('/{id}/downvote', [PortofolioController::class, 'downvote'])->name('downvote');
    Route::post('/{id}/komentar', [PortofolioController::class, 'komentar'])->name('komentar');
});

/*
|--------------------------------------------------------------------------
| Oprek Project Routes
|--------------------------------------------------------------------------
*/

Route::prefix('oprek')->name('oprek.')->group(function () {
    Route::get('/', [OprekProjectController::class, 'index'])->name('index');
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/show/{id}', [OprekProjectController::class, 'show'])->name('show');
        Route::get('/create', [OprekProjectController::class, 'create'])->name('create');
        Route::post('/store', [OprekProjectController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [OprekProjectController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [OprekProjectController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [OprekProjectController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Prestasi Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('prestasi')->name('prestasi.')->group(function () {
    Route::get('/create', [PrestasiController::class, 'create'])->name('create');
    Route::post('/', [PrestasiController::class, 'store'])->name('store');
    Route::get('/{id}', [PrestasiController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PrestasiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PrestasiController::class, 'update'])->name('update');
    Route::post('/{id}/komentar', [PrestasiController::class, 'komentar'])->name('komentar');
});

/*
|--------------------------------------------------------------------------
| Pengabdian Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('pengabdian')->name('pengabdian.')->group(function () {
    Route::get('/create', [PengabdianController::class, 'create'])->name('create');
    Route::post('/', [PengabdianController::class, 'store'])->name('store');
    Route::get('/{id}', [PengabdianController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PengabdianController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PengabdianController::class, 'update'])->name('update');
    Route::post('/{id}/komentar', [PengabdianController::class, 'komentar'])->name('komentar');
});

/*
|--------------------------------------------------------------------------
| Sertifikasi Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('sertifikasi')->name('sertifikasi.')->group(function () {
    Route::get('/create', [SertifikasiController::class, 'create'])->name('create');
    Route::post('/', [SertifikasiController::class, 'store'])->name('store');
    Route::get('/{id}', [SertifikasiController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [SertifikasiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SertifikasiController::class, 'update'])->name('update');
    Route::post('/{id}/komentar', [SertifikasiController::class, 'komentar'])->name('komentar');
});

/*
|--------------------------------------------------------------------------
| Event Routes
|--------------------------------------------------------------------------
*/

// Event Routes
Route::prefix('event')->name('event.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/show/{id}', [EventController::class, 'show'])->name('show');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/store', [EventController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [EventController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [EventController::class, 'destroy'])->name('destroy');
        Route::get('/register/{id}', [EventRegistrationController::class, 'register'])->name('register');
        Route::post('/register/{id}', [EventRegistrationController::class, 'store'])->name('register.store');
        Route::post('/cek-promo', [EventRegistrationController::class, 'cekPromo'])->name('cek.promo');
    });
});

// Route::get('/cek-promo', [EventRegistrationController::class, 'cekPromo'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| Download Routes
|--------------------------------------------------------------------------
*/

Route::prefix('download')->name('download.')->group(function () {
    Route::get('/', [DownloadController::class, 'index'])->name('index');
    Route::get('/file/{id}', [DownloadController::class, 'downloadFile'])->name('file');
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/create', [DownloadController::class, 'create'])->name('create');
        Route::post('/store', [DownloadController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DownloadController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [DownloadController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [DownloadController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Notifikasi Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('notifikasi')->name('notifikasi.')->group(function () {
    Route::get('/', [NotifikasiController::class, 'index'])->name('index');
    Route::post('/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('read');
});

/*
|--------------------------------------------------------------------------
| Komentar Portofolio Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('portofolio/{id_portofolio}/komentar')->name('komentar.')->group(function () {
    Route::get('/', [KomentarPortofolioController::class, 'index'])->name('index');
    Route::post('/', [KomentarPortofolioController::class, 'store'])->name('store');
    Route::get('/{id_komentar}', [KomentarPortofolioController::class, 'show'])->name('show');
    Route::put('/{id_komentar}', [KomentarPortofolioController::class, 'update'])->name('update');
    Route::delete('/{id_komentar}', [KomentarPortofolioController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Validation Routes
    Route::post('/oprek/{id}/validate', [OprekProjectController::class, 'validateProject'])->name('oprek.validate');
    Route::post('/portofolio/{id}/validate', [PortofolioController::class, 'validatePortofolio'])->name('portofolio.validate');
    Route::post('/prestasi/{id}/validate', [PrestasiController::class, 'validatePrestasi'])->name('prestasi.validate');
    Route::post('/pengabdian/{id}/validate', [PengabdianController::class, 'validatePengabdian'])->name('pengabdian.validate');
    Route::post('/sertifikasi/{id}/validate', [SertifikasiController::class, 'validateSertifikasi'])->name('sertifikasi.validate');
    Route::post('/event/{id_event}/validate', [EventController::class, 'validateEvent'])->name('event.validate');
    Route::post('/download/{id}/validate', [DownloadController::class, 'validateDownload'])->name('download.validate');
    Route::post('/pembayaran/{id}/validasi', [PembayaranEventInternalController::class, 'validasi'])->name('pembayaran.validasi');
    Route::post('/user/{id}/validate', [UserController::class, 'validateUser'])->name('user.validate');
});

require __DIR__ . '/auth.php';