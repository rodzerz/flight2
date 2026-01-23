<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    // Šī metode tiks izsaukta no Route
    public function index()
    {
        $flights = Flight::all(); // vai ->paginate(10)
        return view('flights.index', compact('flights'));
    }
}
