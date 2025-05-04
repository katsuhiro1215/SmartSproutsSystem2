<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\MembershipOptionController;

require __DIR__ . '/admin_auth.php';

Route::middleware(['auth:admins', 'verified'])->group(function () {
  Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
    Route::get('/', 'index')->name('dashboard');
  });
  
  // Setting
  Route::controller(SettingController::class)->prefix('setting')->group(function () {
    Route::get('/', 'index')->name('setting.index');
  });

  // Organization
  Route::resource('/organization', OrganizationController::class);
  Route::controller(OrganizationController::class)->prefix('organization')->group(function () {
    // API
    Route::get('/email/checkEmail', 'checkEmail')->name('organization.checkEmail');
  });

  // MembershipOption
  Route::resource('/membershipOption', MembershipOptionController::class);
  Route::controller(MembershipOptionController::class)->prefix('membershipOption')->group(function () {
    // 復活 / 完全削除
    Route::patch('/{membershipOption}/restore', 'restore')->name('membershipOption.restore');
    Route::delete('/{membershipOption}/forceDelete', 'forceDelete')->name('membershipOption.forceDelete');
  });

  require __DIR__ . '/admin/admin.php';
  require __DIR__ . '/admin/store.php';
  require __DIR__ . '/admin/class.php';
  
  require __DIR__ . '/admin/user.php';
});

