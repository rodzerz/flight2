<?php

namespace App\Http\Controllers;

use App\Models\Flight;

class FlightController extends Controller
{
    // Page with the map
    public function index()
    {
        return view('flights.index');
    }

    
    public function api()
    {
        return Flight::select(
            'id',
            'callsign',
            'latitude',
            'longitude',
            'on_ground',
            'heading',
            'velocity',
            'baro_altitude',
            'geo_altitude'
        )->get();
    }
}
