<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PengajuanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->json([
        'success' => false,
        'message' => 'Account ini tidak diizinkan'
    ], 401);
})->name('login');


// ACCOUNT
Route::get('account', [AccountController::class, 'read']);
Route::post('account/signin', [AccountController::class, 'signin']);
Route::post('account/create', [AccountController::class, 'create']);
Route::post('account/update', [AccountController::class, 'update'])->middleware('auth:sanctum');
Route::post('account/delete', [AccountController::class, 'delete'])->middleware('auth:sanctum');


// GUEST
Route::get('guest', [GuestController::class, 'read']);
Route::post('guest/create', [GuestController::class, 'create'])->middleware('auth:sanctum');
Route::post('guest/update', [GuestController::class, 'update'])->middleware('auth:sanctum');
Route::post('guest/delete', [GuestController::class, 'delete'])->middleware('auth:sanctum');

// PENGAJUAN
Route::get('pengajuan', [PengajuanController::class, 'read']);
Route::post('pengajuan/create', [PengajuanController::class, 'create'])->middleware('auth:sanctum');
Route::post('pengajuan/update', [PengajuanController::class, 'update'])->middleware('auth:sanctum');
Route::post('pengajuan/delete', [PengajuanController::class, 'delete'])->middleware('auth:sanctum');


// 