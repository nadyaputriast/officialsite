<?php

use App\Http\Controllers\AdminPortofolioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\PortofolioController;

Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('admin')) {
        return redirect('/admin');
    } elseif (Auth::user()->hasRole('mahasiswa')) {
        return app(DashboardMahasiswaController::class)->index();
    } elseif (Auth::user()->hasRole('dosen')) {
        return app(DashboardDosenController::class)->index();
    }
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio.create');
    Route::post('/portofolio', [PortofolioController::class, 'store'])->name('portofolio.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/portofolio', [AdminPortofolioController::class, 'index'])->name('admin.portofolio.index');
    Route::post('/admin/portofolio/{id}/approve', [AdminPortofolioController::class, 'approve'])->name('admin.portofolio.approve');
    Route::post('/admin/portofolio/{id}/reject', [AdminPortofolioController::class, 'reject'])->name('admin.portofolio.reject');
});

require __DIR__ . '/auth.php';
