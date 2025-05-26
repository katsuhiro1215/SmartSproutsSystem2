<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Event\EventController;
use App\Http\Controllers\Admin\Event\EventScheduleController;

// イベント
Route::resource('/event', EventController::class);
Route::controller(EventController::class)->prefix('event')->group(function () {
  // 復活 / 完全削除
  Route::patch('/{event}/restore', 'restore')->name('event.restore');
  Route::delete('/{event}/forceDelete', 'forceDelete')->name('event.forceDelete');
});

// イベントスケジュール
Route::prefix('{event}')->group(function () {
  Route::resource('/eventSchedule', EventScheduleController::class)->except('index');
  Route::controller(EventScheduleController::class)->prefix('eventSchedule')->group(function () {
    // 復活 / 完全削除
    Route::get('/restore', 'restore')->name('event.restore');
    Route::delete('/forceDelete', 'forceDelete')->name('event.forceDelete');
    // 一括削除
    Route::get('bulk/delete', 'bulkDelete')->name('eventSchedule.bulkDelete');
    Route::post('bulk/destroy', 'bulkDestroy')->name('eventSchedule.bulkDestroy');
    // API
    Route::post('search', 'search')->name('eventSchedule.search');
    Route::get('schedule/fetch', 'fetchByEvent')->name('eventSchedule.fetchByCourse');
    Route::post('/event/schedules/validate', 'validateSchedule')->name('eventSchedule.validate');
  });
});
