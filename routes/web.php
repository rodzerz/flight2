<?php

use App\Http\Controllers\FlightController;

Route::get('/', [FlightController::class, 'index']);
Route::get('/api/flights', [FlightController::class, 'api']);
