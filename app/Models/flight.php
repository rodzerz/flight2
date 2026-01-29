<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $table = 'flights';

    protected $fillable = [
        'callsign',
        'longitude',
        'latitude',
        'on_ground',
        'velocity',
        'heading',
        'baro_altitude',
        'geo_altitude',
        'last_contact',
        'snapshot_time',
    ];

    protected $casts = [
        'on_ground' => 'boolean',
        'longitude' => 'float',
        'latitude'  => 'float',
        'velocity'  => 'float',
        'heading'   => 'float',
        'baro_altitude'  => 'float',
        'geo_altitude'   => 'float',
    ];
}
