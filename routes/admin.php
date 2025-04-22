<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

require __DIR__ . '/admin_auth.php';

Route::middleware(['auth:admins', 'verified'])->group(function () {
  
  Route::get('/dashboard', function () {
    return Inertia::render('Admin/AdminDashboard');
  })->name('dashboard');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
