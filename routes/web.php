<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\Api\MenuController as ApiMenuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/event', [HomeController::class, 'event'])->name('event');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/get-quote', [HomeController::class, 'getQuote'])->name('get.quote');

// API Routes
Route::get('/api/menu/{kategori}', [ApiMenuController::class, 'getByKategori']);

// Protected Routes (Login Required)
Route::middleware(['auth'])->group(function () {
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/create', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan/{id}/batal', [PemesananController::class, 'batal'])->name('pemesanan.batal');
});

// Admin Routes (Login + Admin Role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('menu', App\Http\Controllers\Admin\MenuController::class);
    Route::resource('event', App\Http\Controllers\Admin\EventController::class);
    Route::resource('paket', App\Http\Controllers\Admin\PaketController::class);
    Route::get('/pemesanan', [App\Http\Controllers\Admin\PemesananController::class, 'index'])->name('pemesanan');
    Route::get('/pemesanan/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'show'])->name('pemesanan.show');
    Route::put('/pemesanan/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'updateStatus'])->name('pemesanan.update');
});