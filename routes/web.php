<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');

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
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/absensi', [\App\Http\Controllers\AdminController::class, 'absensi'])->name('admin.absensi');
    Route::get('/admin/mahasantri', [\App\Http\Controllers\AdminController::class, 'mahasantri'])->name('admin.mahasantri');

    // User Management Routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/mahasantri', [\App\Http\Controllers\MahasantriController::class, 'index'])->name('mahasantri.index');
    Route::get('/mahasantri/create', [\App\Http\Controllers\MahasantriController::class, 'create'])->name('mahasantri.create');
    Route::post('/admin/mahasantri', [\App\Http\Controllers\MahasantriController::class, 'store'])->name('admin.mahasantri.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
