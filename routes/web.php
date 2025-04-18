<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('admin')) {
        return view('admin.dashboard');
    } elseif (Auth::user()->hasRole('dosen')) {
        return view('userdosen.dashboard');
    } elseif (Auth::user()->hasRole('mahasiswa')) {
        return view('mahasiswa.dashboard');
    }
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';