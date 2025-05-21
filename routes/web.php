<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/home', [Dashboard::class, 'read']);

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/dashboard', [Dashboard::class, 'read']);
Route::get('/dashboard/data', [Dashboard::class, 'read'])->name('dashboard.data');