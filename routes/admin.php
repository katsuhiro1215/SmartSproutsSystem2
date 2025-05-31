<?php

use App\Http\Controllers\Admin\CalendarController;
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

  Route::controller(CalendarController::class)->prefix('calendar')->group(function () {
    // 全店舗のカレンダー
    Route::get('yearly', 'yearly')->name('calendar.yearly');
    Route::get('monthly', 'monthly')->name('calendar.monthly');
    Route::get('weekly', 'weekly')->name('calendar.weekly');
    Route::get('daily', 'daily')->name('calendar.daily');

    // 各店舗のカレンダー
    Route::get('store/{store}/yearly', 'storeYearly')->name('calendar.storeYearly');
    Route::get('store/{store}/monthly', 'storeMonthly')->name('calendar.storeMonthly');
    Route::get('store/{store}/weekly', 'storeWeekly')->name('calendar.storeWeekly');
    Route::get('store/{store}/daily', 'storeDaily')->name('calendar.storeDaily');
  });
  
  require __DIR__ . '/admin/store.php';
  require __DIR__ . '/admin/user.php';
  require __DIR__ . '/admin/class.php';
  require __DIR__ . '/admin/event.php';
  require __DIR__ . '/admin/questionnaire.php';
});

