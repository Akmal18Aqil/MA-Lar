<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasantriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('login');
    }
    $role = \Illuminate\Support\Facades\Auth::user()->role ?? null;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'dosen') {
        return redirect()->route('dosen.dashboard');
    } elseif ($role === 'mahasantri') {
        return redirect()->route('mahasantri.dashboard');
    } else {
        abort(403, 'Unauthorized');
    }
})->name('home');

Route::middleware(['auth', 'role:mahasantri'])->group(function () {
    Route::get('/mahasantri/dashboard', function () {
        return view('mahasantri.dashboard');
    })->name('mahasantri.dashboard');
    // Add mahasantri specific routes here
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen/dashboard', function () {
        return view('dosen.dashboard');
    })->name('dosen.dashboard');
    // Add dosen specific routes here
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Mahasantri routes
        Route::get('/mahasantri/create', [MahasantriController::class, 'create'])->name('mahasantri.create');
        Route::post('/mahasantri', [MahasantriController::class, 'store'])->name('mahasantri.store');
        Route::get('/mahasantri', [MahasantriController::class, 'index'])->name('mahasantri.index');
        Route::get('/mahasantri/{mahasantri}/edit', [MahasantriController::class, 'edit'])->name('mahasantri.edit');
        Route::put('/mahasantri/{mahasantri}', [MahasantriController::class, 'update'])->name('mahasantri.update');
        Route::delete('/mahasantri/{mahasantri}', [MahasantriController::class, 'destroy'])->name('mahasantri.destroy');

        // Other admin routes
        // Route::get('/absensi', [AdminController::class, 'absensi'])->name('absensi');

        // Absensi CRUD
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/absensi/{absensi}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('/absensi/{absensi}', [AbsensiController::class, 'update'])->name('absensi.update');
        Route::delete('/absensi/{absensi}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');

        // Export Excel Rekap Absensi
        Route::get('/absensi/export', [AbsensiController::class, 'export'])->name('absensi.export');

        // Hapus libur route
        Route::get('/absensi/hapus-libur', [AbsensiController::class, 'hapusLibur'])->name('absensi.hapusLibur');

        // UKT Payment routes
        Route::resource('ukt', \App\Http\Controllers\UktPaymentController::class);
        Route::get('ukt/export', [\App\Http\Controllers\UktPaymentController::class, 'export'])->name('ukt.export');
    });

    // User Management Routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
