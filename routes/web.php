<?php

use App\Http\Controllers\AdminPortofolioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\OprekProjectController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('admin')) {
        return app(DashboardController::class)->index();
    } elseif (Auth::user()->hasRole('mahasiswa')) {
        return app(DashboardController::class)->index();
    } elseif (Auth::user()->hasRole('dosen')) {
        return app(DashboardController::class)->index();
    }
})->middleware(['auth'])->name('dashboard');

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio.create');
    Route::post('/portofolio', [PortofolioController::class, 'store'])->name('portofolio.store');
    Route::get('/portofolio/{id}', [PortofolioController::class, 'show'])->name('portofolio.show');
    Route::put('/portofolio/{id}', [PortofolioController::class, 'update'])->name('portofolio.update');
    Route::get('/portofolio/{id}/edit', [PortofolioController::class, 'edit'])->name('portofolio.edit');
    
    Route::get('/oprek', [OprekProjectController::class, 'create'])->name('oprek.create');
    Route::post('/oprek', [OprekProjectController::class, 'store'])->name('oprek.store');
    Route::get('/oprek/{id}', [OprekProjectController::class, 'show'])->name('oprek.show');
    Route::put('/oprek/{id}', [OprekProjectController::class, 'update'])->name('oprek.update');
    Route::get('/oprek/{id}/edit', [OprekProjectController::class, 'edit'])->name('oprek.edit');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/portofolio', [AdminPortofolioController::class, 'index'])->name('admin.portofolio.index');
    Route::post('/admin/portofolio/{id}/approve', [AdminPortofolioController::class, 'approve'])->name('admin.portofolio.approve');
    Route::post('/admin/portofolio/{id}/reject', [AdminPortofolioController::class, 'reject'])->name('admin.portofolio.reject');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/oprek/{id}/validate', [OprekProjectController::class, 'validateProject'])->name('oprek.validate');
    Route::post('/portofolio/{id}/validate', [PortofolioController::class, 'validatePortofolio'])->name('portofolio.validate');
});


require __DIR__ . '/auth.php';
