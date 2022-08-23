<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// authentication
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::prefix('v1')->name('api.')->group(function () {
    Route::get('events/active-events', [EventController::class, 'activeEvent'])->name('event.active-event');
    Route::resource('events', EventController::class)->only(['show', 'index', 'create', 'edit'])->parameter('events','id')->names('event');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->name('api.')->group(function () {
        Route::resource('events', EventController::class)->except(['create', 'edit', 'show', 'index'])->parameter('events','id')->names('v1.event');
    });
});


