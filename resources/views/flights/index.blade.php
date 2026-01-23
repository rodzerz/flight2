<h1>Flights</h1>

@foreach ($flights as $flight)
    <p>{{ $flight->callsign}}</p>
    <p>{{ $flight->time}}</p>
    <p>{{ $flight->states}}</p>
    <p>{{ $flight->longitude}}</p>
    <p>{{ $flight->latitude}}</p>
    <p>{{ $flight->velocity}}</p>
    <p>{{ $flight->on_ground}}</p>
    <p>{{ $flight->baro_altitude }}</p>
    <p>{{ $flight->geo_altitude }}</p>
    <p>{{ $flight->last_contact }}</p>
@endforeach
