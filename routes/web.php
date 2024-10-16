<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LinkController;
use App\Http\Middleware\ActiveLinkMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('register', [RegisteredUserController::class, 'store'])->name('registerUser');

Route::get('link/{hash}', [LinkController::class, 'open'])
    ->name('open')->middleware(ActiveLinkMiddleware::class);

Route::post('link/{hash}/deactivate', [LinkController::class, 'deactivate'])
    ->name('deactivate');

Route::post('link/{hash}/update', [LinkController::class, 'update'])
    ->name('update');

Route::get('history', [HistoryController::class, 'history'])
    ->name('getHistory');

Route::get('play', [GameController::class, 'play'])
    ->name('play');

