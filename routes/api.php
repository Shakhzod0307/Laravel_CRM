<?php

use App\Http\Controllers\TelegramBot\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('telegram/webhook', [TelegramController::class, 'handle']);
