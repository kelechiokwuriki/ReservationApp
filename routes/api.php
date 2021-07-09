<?php

use App\Http\Controllers\Api\ReservationSettingsController;
use App\User;
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

Route::get('/user', function (Request $request) {
    return User::all();
});

Route::resource('reservationSettings', 'Api\ReservationSettingsController');
Route::resource('reservation', 'Api\ReservationController');

