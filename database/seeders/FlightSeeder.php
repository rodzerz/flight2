<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Flight;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::WithoutVerifying()->get('https://opensky-network.org/api/states/all');

        if (! $response->successful()) {
            $this->command->error('API request failed');
            return;
        }

        $data = $response->json();

        $snapshotTime = $data['time'];
        $states = $data['states'];

        $flights = [];

        foreach ($states as $state) {
            
            $callsign = trim($state[1] ?? '');

            if ($callsign === '') {
                continue;
            }

            $flights[] = [
                'callsign'       => $callsign,
                'longitude'      => $state[5] ?? null,
                'latitude'       => $state[6] ?? null,
                'on_ground'      => $state[8] ?? false,
                'velocity'       => $state[9] ?? null,
                'heading'        => $state[10] ?? null,
                'baro_altitude'  => $state[7] ?? null,
                'geo_altitude'   => $state[13] ?? null,
                'last_contact'   => $state[4] ?? null,
                'snapshot_time'  => $snapshotTime,
                'updated_at'     => now(),
                'created_at'     => now(),
            ];
        }

       collect($flights)
    ->chunk(500)
    ->each(function ($chunk) {
        Flight::upsert(
            $chunk->toArray(),
            ['callsign'],
            [
                'longitude',
                'latitude',
                'on_ground',
                'velocity',
                'heading',
                'baro_altitude',
                'geo_altitude',
                'last_contact',
                'snapshot_time',
                'updated_at',
            ]
        );
    });

    }
}
