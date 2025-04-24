<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

require __DIR__ . '/admin_auth.php';

Route::middleware(['auth:admins', 'verified'])->group(function () {
  Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
    Route::get('/', 'index')->name('dashboard');
  });
  
  // Setting
  Route::controller(SettingController::class)->prefix('setting')->group(function () {
    Route::get('/', 'index')->name('setting.index');
  });

  require __DIR__ . '/admin/admin.php';
});

