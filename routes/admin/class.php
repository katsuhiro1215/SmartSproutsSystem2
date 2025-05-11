<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Class\ClassController;
use App\Http\Controllers\Admin\Class\LessonController;
use App\Http\Controllers\Admin\Class\CourseCategoryController;
use App\Http\Controllers\Admin\Class\CourseController;
use App\Http\Controllers\Admin\Class\CourseScheduleController;

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

// Course
Route::resource('/course', CourseController::class);
Route::controller(CourseController::class)->prefix('course')->group(function () {
  Route::get('/{course}/restore', 'restore')->name('course.restore');
  Route::delete('/{course}/forceDelete', 'forceDelete')->name('course.forceDelete');
});

// Course Schedule
Route::resource('/courseSchedule', CourseScheduleController::class);
Route::controller(CourseScheduleController::class)->prefix('courseSchedule')->group(function () {
  // 復活 / 完全削除
  Route::get('/{course}/restore', 'restore')->name('course.restore');
  Route::delete('/{course}/forceDelete', 'forceDelete')->name('course.forceDelete');
  // 一括削除
  Route::get('bulk/delete', 'bulkDelete')->name('courseSchedule.bulkDelete');
  Route::post('bulk/destroy', 'bulkDestroy')->name('courseSchedule.bulkDestroy');
  // API
  Route::post('search', 'search')->name('courseSchedule.search');
});
