<?php

use App\Http\Controllers\authentications\Logout;
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


// Main Page Route
Route::middleware('auth')->get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login', [LoginBasic::class, 'index'])->name('auth-login');
Route::post('/auth/login', [LoginBasic::class, 'login'])->name('auth-login-check');
Route::get('/auth/register', [RegisterBasic::class, 'index'])->name('auth-register');
Route::post('/auth/register', [RegisterBasic::class, 'store'])->name('auth-register-store');
Route::post('/auth/logout', [Logout::class, 'logout'])->name('logout');
Route::get('/auth/forgot-password', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');



Route::middleware(['auth'])->group(function () {
  Route::get('/chats/index',function (){
    return view('chat.index');
  });
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat');

  Route::get('/messages/{user}', [ChatController::class, 'index']);
  Route::post('/messages/{user}', [ChatController::class, 'sendMessage']);
});
