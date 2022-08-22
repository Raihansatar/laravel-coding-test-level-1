<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->name('api.')->group(function () {
    Route::get('events/active-events', [EventController::class, 'activeEvent'])->name('v1.event.active-event');
    Route::resource('events', EventController::class)->except(['create', 'edit'])->parameter('events','id')->names('v1.event');
});
