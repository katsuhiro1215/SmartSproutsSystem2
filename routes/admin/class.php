<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Class\ClassController;
use App\Http\Controllers\Admin\Class\CourseCategoryController;
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

// CourseCategory
Route::resource('/courseCategory', CourseCategoryController::class);
Route::controller(CourseCategoryController::class)->prefix('courseCategory')->group(function () {
  Route::get('/{courseCategory}/restore', 'restore')->name('courseCategory.restore');
  Route::delete('/{courseCategory}/forceDelete', 'forceDelete')->name('courseCategory.forceDelete');
});
