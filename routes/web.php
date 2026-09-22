<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoCompleteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest / Publik — FR-1)
|--------------------------------------------------------------------------
*/
Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Perkumpulan Routes (auth + perkumpulan role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'perkumpulan'])->prefix('perkumpulan')->name('perkumpulan.')->group(function () {
    // Dashboard
    Route::get('/', [PendaftaranController::class, 'dashboard'])->name('dashboard');

    // Pendaftaran atlet
    Route::get('/events/{event}/daftar', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/events/{event}/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/pendaftaran/{pendaftaran}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
    Route::put('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
    Route::delete('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

    // Auto-complete & auto-match (AJAX)
    Route::get('/autocomplete/atlet', [AutoCompleteController::class, 'atlet'])->name('autocomplete.atlet');
    Route::get('/autocomplete/waktu', [AutoCompleteController::class, 'waktu'])->name('autocomplete.waktu');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (auth + admin role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // --- Event Management ---
    Route::resource('events', Admin\EventController::class);

    // --- Kelompok Umur (nested under event) ---
    Route::prefix('events/{event}/ku')->name('events.ku.')->group(function () {
        Route::get('/', [Admin\KelompokUmurController::class, 'index'])->name('index');
        Route::get('/create', [Admin\KelompokUmurController::class, 'create'])->name('create');
        Route::post('/', [Admin\KelompokUmurController::class, 'store'])->name('store');
        Route::get('/{ku}/edit', [Admin\KelompokUmurController::class, 'edit'])->name('edit');
        Route::put('/{ku}', [Admin\KelompokUmurController::class, 'update'])->name('update');
        Route::delete('/{ku}', [Admin\KelompokUmurController::class, 'destroy'])->name('destroy');
    });

    // --- Nomor Lomba (nested under KU) ---
    Route::prefix('ku/{ku}/nomor')->name('ku.nomor.')->group(function () {
        Route::get('/', [Admin\NomorLombaController::class, 'index'])->name('index');
        Route::get('/create', [Admin\NomorLombaController::class, 'create'])->name('create');
        Route::post('/', [Admin\NomorLombaController::class, 'store'])->name('store');
        Route::get('/{nomor}/edit', [Admin\NomorLombaController::class, 'edit'])->name('edit');
        Route::put('/{nomor}', [Admin\NomorLombaController::class, 'update'])->name('update');
        Route::delete('/{nomor}', [Admin\NomorLombaController::class, 'destroy'])->name('destroy');
    });

    // --- User / Perkumpulan Management ---
    Route::resource('users', Admin\UserController::class);

    // --- Import & Export ---
    Route::get('/import/riwayat', [Admin\ImportController::class, 'showForm'])->name('import.form');
    Route::post('/import/riwayat', [Admin\ImportController::class, 'riwayat'])->name('import.riwayat');

    Route::get('/export/pendaftaran/{event}', [Admin\ExportController::class, 'pendaftaran'])->name('export.pendaftaran');

    // --- Override Admin (FR-14) ---
    Route::put('/override/pendaftaran/{pendaftaran}', [Admin\ExportController::class, 'overrideUpdate'])->name('override.update');
    Route::delete('/override/pendaftaran/{pendaftaran}', [Admin\ExportController::class, 'overrideDelete'])->name('override.delete');

    // --- Audit Log ---
    Route::get('/audit-log', [Admin\ExportController::class, 'auditLog'])->name('audit-log');
});
