<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaketController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/event', [HomeController::class, 'event'])->name('event');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Route untuk pemesanan (perlu login)
Route::middleware(['auth'])->group(function () {
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/create', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');
});

// Route Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Menu
    Route::resource('menu', MenuController::class);
    
    // CRUD Event
    Route::resource('event', EventController::class);
    
    // CRUD Paket
    Route::resource('paket', PaketController::class);
    
    // Manajemen Pemesanan
    Route::get('/pemesanan', [AdminController::class, 'pemesanan'])->name('pemesanan');
    Route::put('/pemesanan/{id}', [AdminController::class, 'updateStatus'])->name('pemesanan.update');
});