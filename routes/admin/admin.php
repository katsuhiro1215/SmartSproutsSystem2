<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminEnrollmentController;

// 自身のアカウント管理
Route::prefix('account')->name('account.')->controller(AdminController::class)->group(function () {
  Route::get('/edit', 'edit')->name('edit');
  Route::patch('/', 'update')->name('update');
});

// オーナー
Route::prefix('owner')->name('owner.')->controller(OwnerController::class)->group(function () {
  Route::get('{admin}/show', 'show')->name('show');
});

// 管理者管理
Route::prefix('admin')->name('admin.')->controller(AdminController::class)->group(function () {
  Route::get('index', 'index')->name('index');
  Route::get('create', 'create')->name('create');
  Route::post('/', 'store')->name('store');
  Route::get('{admin}/show', 'show')->name('show');
  Route::get('{admin}/edit', 'edit')->name('edit');
  Route::put('{admin}', 'update')->name('update');
  Route::delete('{admin}', 'destroy')->name('destroy');
  // 復活 / 完全削除
  Route::put('{id}/restore', 'restore')->name('restore');
  Route::delete('{id}/forceDelete', 'forceDelete')->name('forceDelete');
  // API
  Route::get('/email/checkEmail', 'checkEmail')->name('checkEmail');
});

// 従業員管理
Route::prefix('employee')->name('employee.')->controller(EmployeeController::class)->group(function () {
  /* ----- 全体 ----- */
  Route::get('index', 'index')->name('index');
  Route::get('create', 'create')->name('create');
  Route::post('/', 'employeeStore')->name('store');
  Route::get('{admin}/show', 'show')->name('show');
  Route::get('{admin}/edit', 'edit')->name('edit');
  Route::patch('{admin}', 'update')->name('update');
  Route::delete('{admin}', 'destroy')->name('destroy');
  // 復活 / 完全削除
  Route::get('{employee}/restore', 'restore')->name('restore');
  Route::get('{employee}/forceDelete', 'forceDelete')->name('forceDelete');
  // Excel
  Route::get('import', 'import')->name('import');
  Route::get('export', 'export')->name('export');
  // QRコード / カード
  Route::get('{employee}/qrcode', 'generateQRCode')->name('generateQRCode');
  Route::get('{employee}/card', 'card')->name('card');

  // 店舗別
  Route::prefix('{store}')->name('store.')->group(function () {
    Route::get('index', 'employeeIndex')->name('index');
    Route::get('create', 'employeeCreate')->name('create');
    Route::post('/', 'employeeStore')->name('store');
    Route::get('{employee}/show', 'employeeShow')->name('show');
    Route::get('{employee}/edit', 'employeeEdit')->name('edit');
    Route::patch('{employee}', 'employeeUpdate')->name('update');
    Route::delete('{employee}', 'employeeDestroy')->name('destroy');
    Route::get('{employee}/restore', 'employeeRestore')->name('restore');
    Route::get('{employee}/forceDelete', 'employeeForceDelete')->name('forceDelete');
    Route::get('import', 'adminImport')->name('import');
    Route::get('export', 'adminExport')->name('export');
    Route::get('{employee}/qrcode', 'generateQRCode')->name('generateQRCode');
    Route::get('{employee}/card', 'card')->name('card');
  });
});

// その他管理
Route::prefix('other')->name('other.')->controller(AdminController::class)->group(function () {
  /* ----- 全体 ----- */
  Route::get('index', 'otherIndex')->name('index');
  Route::get('create', 'otherCreate')->name('create');
  Route::post('/', 'otherStore')->name('store');
  Route::get('{other}/show', 'otherShow')->name('show');
  Route::get('{other}/edit', 'otherEdit')->name('edit');
  Route::patch('{other}', 'otherUpdate')->name('update');
  Route::delete('{other}', 'otherDestroy')->name('destroy');
  // 復活 / 完全削除
  Route::get('{other}/restore', 'otherRestore')->name('restore');
  Route::get('{other}/forceDelete', 'otherForceDelete')->name('forceDelete');
  // Excel
  Route::get('import', 'adminImport')->name('import');
  Route::get('export', 'adminExport')->name('export');
  // QRコード / カード
  Route::get('{other}/qrcode', 'generateQRCode')->name('generateQRCode');
  Route::get('{other}/card', 'card')->name('card');

  // 店舗別
  Route::prefix('{store}')->name('store.')->group(function () {
    Route::get('index', 'otherIndex')->name('index');
    Route::get('create', 'otherCreate')->name('create');
    Route::post('/', 'otherStore')->name('store');
    Route::get('{other}/show', 'otherShow')->name('show');
    Route::get('{other}/edit', 'otherEdit')->name('edit');
    Route::patch('{other}', 'otherUpdate')->name('update');
    Route::delete('{other}', 'otherDestroy')->name('destroy');
    Route::get('{other}/restore', 'otherRestore')->name('restore');
    Route::get('{other}/forceDelete', 'otherForceDelete')->name('forceDelete');
    Route::get('import', 'adminImport')->name('import');
    Route::get('export', 'adminExport')->name('export');
    Route::get('{other}/qrcode', 'generateQRCode')->name('generateQRCode');
    Route::get('{other}/card', 'card')->name('card');
  });
});

// Auth Profile
Route::controller(AdminProfileController::class)->prefix('profile')->group(function () {
  Route::get('/show', 'show')->name('profile.show');
  Route::get('/edit', 'edit')->name('profile.edit');
  Route::patch('/', 'update')->name('profile.update');
});

// Admin Profile
Route::controller(AdminProfileController::class)->prefix('adminProfile')->group(function () {
  Route::get('/{admin}/create', 'create')->name('adminProfile.create');
  Route::post('/', 'store')->name('adminProfile.store');
  Route::get('/{admin}/{adminProfile}/edit', 'edit')->name('adminProfile.edit');
  Route::put('/{adminProfile}', 'update')->name('adminProfile.update');
});
