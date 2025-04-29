<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\StoreController;

// 店舗
Route::resource('/store', StoreController::class);
Route::controller(StoreController::class)->prefix('store')->group(function () {
  // 復活 / 完全削除
  Route::patch('/{store}/restore', 'restore')->name('store.restore');
  Route::delete('/{store}/forceDelete', 'forceDelete')->name('store.forceDelete');
  // API
  Route::get('/code/checkCode', 'checkCode')->name('store.checkCode');
  Route::get('/email/checkEmail', 'checkEmail')->name('store.checkEmail');
});
