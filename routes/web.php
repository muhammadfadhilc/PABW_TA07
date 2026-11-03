<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanJalanController;
use App\Http\Controllers\RoadWatchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => Auth::check()
    ? redirect()->route('dashboard')
    : redirect()->route('login'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [RoadWatchController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [RoadWatchController::class, 'profile'])->name('profile');

    // Tetap gunakan kontrol status / foto yang sudah ada dari Modul 6.
    Route::get('/laporan/{laporan}/foto', [RoadWatchController::class, 'photo'])->name('laporan.photo');
    Route::patch('/laporan/{laporan}/status', [RoadWatchController::class, 'status'])->name('laporan.status');

    // CRUD lengkap resource: index, create, store, show, edit, update, destroy.
    Route::resource('laporan', LaporanJalanController::class);
});
