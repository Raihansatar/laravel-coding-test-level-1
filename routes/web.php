<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Quote\AnimeQuoteController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// authentication
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


Route::middleware('auth:sanctum')->group(function (){
    Route::resource('events', EventController::class)->except(['show', 'index'])->parameter('events','id')->names('event');
});

Route::get('quote', [AnimeQuoteController::class, 'index'])->name('qoute.index');

Route::get('events/active-events', [EventController::class, 'activeEvent'])->name('event.active-event');
Route::resource('events', EventController::class)->only(['show', 'index'])->parameter('events','id')->names('event');

