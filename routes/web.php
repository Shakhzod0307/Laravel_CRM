<?php

use App\Http\Controllers\authentications\Logout;
use App\Http\Controllers\chat\ChatController;
use App\Http\Controllers\users\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;



Route::middleware(['auth'])->group(function () {
  // Main Page Route
  Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
  // pages
  Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
  Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
  Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
  Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
  Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
  // users
  Route::get('/users/list',[UserController::class, 'users'])->name('users-list');

});

// authentication
Route::get('/auth/login', [LoginBasic::class, 'index'])->name('login');
Route::post('/auth/login', [LoginBasic::class, 'login'])->name('auth-login-check');
Route::get('/auth/register', [RegisterBasic::class, 'index'])->name('auth-register');
Route::post('/auth/register', [RegisterBasic::class, 'store'])->name('auth-register-store');
Route::post('/auth/logout', [Logout::class, 'logout'])->name('logout');
Route::get('/auth/forgot-password', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');


// chat
Route::middleware(['auth'])->group(function () {
  Route::get('/chats/index',[ChatController::class,'users'])->name('other-users');
  Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat');

  Route::get('/messages/{user}', [ChatController::class, 'index']);
  Route::post('/messages/{user}', [ChatController::class, 'sendMessage']);
});
