<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flight;

class MoveFlights extends Command
{
    protected $signature = 'flights:move';
    protected $description = 'Move flights forward';

    public function handle()
    {
        $flights = Flight::where('on_ground', false)->get();

        foreach ($flights as $flight) {
            $speed = $flight->velocity ?? 800; 
            $distance = $speed * 0.00002;     

            $flight->latitude += cos(deg2rad($flight->heading)) * $distance;
            $flight->longitude += sin(deg2rad($flight->heading)) * $distance;

            
            if ($flight->longitude > 180) $flight->longitude -= 360;
            if ($flight->longitude < -180) $flight->longitude += 360;

            $flight->save();
        }
    }
}
