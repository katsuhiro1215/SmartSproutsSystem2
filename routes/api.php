<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\StoreScheduleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// 店舗
Route::get('/stores', [StoreController::class, 'fetchStores'])->name('stores.fetch');
// 店舗スケジュール
Route::get('/store/schedules', [StoreScheduleController::class, 'index'])->name('storeSchedules.index');
Route::post('/store/schedules', [StoreScheduleController::class, 'store'])->name('storeSchedules.store');
Route::put('/store/schedules/{id}', [StoreScheduleController::class, 'update'])->name('storeSchedules.update');