<?php

use App\Http\Controllers\authentications\Logout;
use App\Http\Controllers\CallsController;
use App\Http\Controllers\chat\ChatController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\permission\PermissionsController;
use App\Http\Controllers\role\RoleController;
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
  Route::get('/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
  Route::post('/account-settings-account', [AccountSettingsAccount::class, 'update'])->name('user-update-profile');
  Route::get('/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
  Route::get('/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
  Route::get('/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
  Route::get('/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
  // users
  Route::get('/users/list',[UserController::class, 'users'])->name('users-list');
  Route::get('/api/users',[UserController::class, 'usersList'])->name('usersList');
  Route::get('/user/account',[UserController::class, 'account'])->name('user-account');
  //roles
  Route::get('/roles',[RoleController::class, 'roles'])->name('roles');
  Route::get('/roles/index',[RoleController::class, 'index'])->name('role-index');
  Route::get('/role/edit/{id}',[RoleController::class, 'edit'])->name('role-edit');
  Route::post('/role/create', [RoleController::class, 'create'])->name('role-create');
  //permissions
  Route::get('/permissions',[PermissionsController::class, 'roles'])->name('permissions');
  Route::get('/permissions/index',[PermissionsController::class, 'index'])->name('permission-index');
  Route::get('/permission/edit/{id}',[PermissionsController::class, 'edit'])->name('permission-edit');
  Route::post('/permission/create', [PermissionsController::class, 'create'])->name('permission-create');


});

// authentication
Route::get('/auth/login', [LoginBasic::class, 'index'])->name('login');
Route::post('/auth/login', [LoginBasic::class, 'login'])->name('auth-login-check');
Route::get('/auth/register', [RegisterBasic::class, 'index'])->name('auth-register');
Route::post('/auth/register', [RegisterBasic::class, 'store'])->name('auth-register-store');
Route::middleware(['auth'])->post('/auth/logout', [Logout::class, 'logout'])->name('logout');
Route::middleware(['auth'])->get('/auth/forgot-password', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');



Route::middleware(['auth'])->group(function () {
  Route::get('/chats/index',[ChatController::class,'users'])->name('other-users');
  Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat');

  Route::get('/messages/{user}', [ChatController::class, 'index']);
  Route::post('/messages/{user}', [ChatController::class, 'sendMessage']);

  Route::get('/calls/index',[CallsController::class,'index']);
  Route::get('/calls/{number}/{year?}/{month?}/{day?}',[CallsController::class,'calls']);
  Route::get('/callsByDate',[CallsController::class,'callsByDate']);
  Route::post('/calls/{id}/rating',[CallsController::class,'rating']);

  Route::get('/excel/list',[ExcelController::class, 'index']);
  Route::get('/excel-list',[ExcelController::class, 'getAll']);
  Route::get('/excel-export', [ExcelController::class, 'export']);
  Route::post('/excel-import', [ExcelController::class, 'import']);
  Route::post('/excel-drop', [ExcelController::class, 'drop']);
  Route::get('/get-columns', [ExcelController::class, 'getColumns']);
  Route::post('/add-new-column', [ExcelController::class, 'addColumn']);
  Route::post('/drop-columns', [ExcelController::class, 'dropColumn']);
});




require 'telegram.php';
