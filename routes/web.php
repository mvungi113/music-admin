<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Artist
Route::get('/artist/{id}', [UserController::class, 'view'])->name('artist.view');

// User Management
Route::get('/usermanagement', [UserController::class, 'index'])->name('usermanagement');

// Audio
Route::get('/audio/{id}', [AudioController::class, 'view'])->name('audio.view');
Route::get('/audio-submissions', [AudioController::class, 'index'])->name('audio.submissions');
Route::post('/song/{id}/approve', [AudioController::class, 'approve'])->name('song.approve');
Route::post('/song/{id}/reject', [AudioController::class, 'reject'])->name('song.reject');
Route::post('/song/{id}/pending', [AudioController::class, 'pending'])->name('song.pending');

// Reports & Analytics
Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
Route::get('/reports/export', [App\Http\Controllers\ReportsController::class, 'export'])->name('reports.export');

require __DIR__.'/auth.php';
