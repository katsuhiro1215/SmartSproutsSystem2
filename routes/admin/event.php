<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\EventController;

// イベント
Route::resource('/event', EventController::class);
Route::controller(EventController::class)->prefix('event')->group(function () {
  // 復活 / 完全削除
  Route::patch('/{event}/restore', 'restore')->name('event.restore');
  Route::delete('/{event}/forceDelete', 'forceDelete')->name('event.forceDelete');
});

// イベントスケジュール
