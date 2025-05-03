<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserAddressController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\GuardianController;

// User
Route::resource('/user', UserController::class);
Route::controller(UserController::class)->prefix('user')->group(function () {
  Route::put('/{id}/restore', 'restore')->name('user.restore');
  Route::delete('/{id}/forceDelete', 'forceDelete')->name('user.forceDelete');
  // API
  Route::get('/email/checkEmail', 'checkEmail')->name('user.checkEmail');
});
// User Address
Route::resource('/{user}/userAddress', UserAddressController::class)->except('index', 'show');
//Student
Route::resource('/student', StudentController::class);
// Guardian
Route::resource('/guardian', GuardianController::class);
