<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Live Flights Map</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        #map { height: 600px; width: 100%; }

        /* Blink animation for flying planes */
        .flying-dot {
            animation: pulse 1.2s infinite;
        }

        @keyframes pulse {
            0% { r: 3; opacity: 0.8; }
            50% { r: 5; opacity: 1; }
            100% { r: 3; opacity: 0.8; }
        }
    </style>
</head>
<body class="antialiased">
    <h1>Live Flights Map</h1>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([20, 0], 2);

        // OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Store markers so we can update positions
        const flightMarkers = {};

        // Fetch and update flights
        async function updateFlights() {
            try {
                const res = await fetch('/flights');
                const flights = await res.json();

                flights.forEach(flight => {
                    const lat = flight.latitude ?? 0;
                    const lng = flight.longitude ?? 0;

                    // Convert on_ground to boolean
                    let onGround = false;
                    if (flight.on_ground !== undefined) {
                        if (typeof flight.on_ground === 'boolean') {
                            onGround = flight.on_ground;
                        } else if (typeof flight.on_ground === 'string') {
                            onGround = (flight.on_ground.toLowerCase() === 'true' || flight.on_ground === '1');
                        } else if (typeof flight.on_ground === 'number') {
                            onGround = (flight.on_ground === 1);
                        }
                    }

                    const heading = (flight.heading !== undefined && flight.heading !== null) ? flight.heading : 'N/A';

                    const dotColor = onGround ? 'green' : 'red';

                    // Use flight id as key, fallback to lat-lng if no id
                    const id = flight.id ?? `${lat}_${lng}`;

                    if (flightMarkers[id]) {
                        // Update existing marker position and color
                        flightMarkers[id].setLatLng([lat, lng]);
                        flightMarkers[id].setStyle({ fillColor: dotColor, color: dotColor });
                    } else {
                        // Create new marker
                        const marker = L.circleMarker([lat, lng], {
                            radius: 4,
                            fillColor: dotColor,
                            color: dotColor,
                            weight: 0,
                            fillOpacity: 0.9
                        });

                        marker.bindPopup(`
                            <b>Flight Info:</b><br>
                            Latitude: ${lat}<br>
                            Longitude: ${lng}<br>
                            On Ground: ${onGround}<br>
                            Heading: ${heading}
                        `);

                        marker.addTo(map);
                        flightMarkers[id] = marker;
                    }
                });
            } catch (err) {
                console.error('Failed to load flights:', err);
            }
        }

        // Initial load
        updateFlights();

        // Update every 5 seconds
        setInterval(updateFlights, 5000);
    </script>
</body>
</html>
