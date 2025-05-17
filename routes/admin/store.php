<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\StoreScheduleController;

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

// 店舗スケジュール
Route::resource('/storeSchedule', StoreScheduleController::class)->except('create');
Route::controller(StoreScheduleController::class)->prefix('storeSchedule')->group(function () {
  // 一括処理 (作成画面、保存、削除画面、削除)
  Route::get('bulk/{store}/create', 'bulkCreate')->name('storeSchedule.bulkCreate');
  Route::post('bulk/store', 'bulkStore')->name('storeSchedule.bulkStore');
  Route::get('bulk/delete', 'bulkDelete')->name('storeSchedule.bulkDelete');
  Route::post('bulk/destroy', 'bulkDestroy')->name('storeSchedule.bulkDestroy');
  // API
  Route::get('schedule/{storeId}', 'fetchByStore')->name('storeSchedule.fetchByStore');
  Route::get('schedule/fetch', 'fetch')->name('storeSchedule.fetch');
});