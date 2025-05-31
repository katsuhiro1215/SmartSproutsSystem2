<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Questionnaire\QuestionnaireController;

// イベント
Route::resource('/questionnaire', QuestionnaireController::class);
Route::controller(QuestionnaireController::class)->prefix('questionnaire')->group(function () {
  // 復活 / 完全削除
  Route::patch('/{questionnaire}/restore', 'restore')->name('questionnaire.restore');
  Route::delete('/{questionnaire}/forceDelete', 'forceDelete')->name('questionnaire.forceDelete');
});

