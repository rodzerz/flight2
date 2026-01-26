<?php

use Illuminate\Support\Facades\Route;
use App\Models\Flight;

use App\Http\Controllers\FlightController;

Route::get('/flights', [FlightController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/flights', function () {
    return Flight::all(['latitude', 'longitude',]);
});
Route::get('/flights-map', function () {
    return view('welcome');
});
