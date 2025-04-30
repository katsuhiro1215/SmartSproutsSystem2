<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Class\ClassController;
use App\Http\Controllers\Admin\Class\LessonController;

// Class (Dashboard)
Route::controller(ClassController::class)->prefix('class')->group(function () {
  Route::get('/', 'index')->name('class.index');
});

// Lesson
Route::resource('/lesson', LessonController::class);
Route::controller(LessonController::class)->prefix('lesson')->group(function () {
  Route::get('/{lesson}/restore', 'restore')->name('lesson.restore');
  Route::delete('/{lesson}/forceDelete', 'forceDelete')->name('lesson.forceDelete');
});

