<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('term')->group(function () {
    Route::post('', [TermController::class, 'store']);
});

Route::prefix('user')->group(function () {
    Route::post('', [UserController::class, 'store']);
});

Route::prefix('game')->group(function () {
    Route::post('', [GameController::class, 'store']);
    Route::get('', [GameController::class, 'index']);
});
