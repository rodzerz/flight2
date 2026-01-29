<!DOCTYPE html>
<html>
<head>
    <title>Live Flight Radar</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 600px; width: 100%; }
    </style>
</head>
<body>

<h1>Live Flights Map</h1>
<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([20, 0], 2);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

const markers = {};

async function updateFlights() {
    try {
        const res = await fetch('/api/flights');
        const flights = await res.json();

        flights.forEach(f => {
            const id = f.id;
            const latlng = [f.latitude, f.longitude];
            const color = f.on_ground ? 'green' : 'red';

           const popupContent = `
    <b>Reisa numurs:</b> ${f.callsign ?? 'Unknown'}<br>
    <b>Augstums:</b> ${f.baro_altitude ?? f.geo_altitude ?? 'N/A'} m<br>
    <b>Ātrums:</b> ${f.velocity ?? 'N/A'} km/h<br>
    <b>Virziens:</b> ${f.heading ?? 'N/A'}°<br>
    <b>On Ground:</b> ${f.on_ground ? 'Jā' : 'Nē'}
`;

            if (markers[id]) {
                markers[id].setLatLng(latlng);
                markers[id].bindPopup(popupContent);
            } else {
                markers[id] = L.circleMarker(latlng, {
                    radius: 4,
                    color,
                    fillColor: color,
                    fillOpacity: 0.9
                }).addTo(map)
                .bindPopup(popupContent);
            }
        });
    } catch(err) {
        console.error('Failed to load flights:', err);
    }
}

updateFlights();
setInterval(updateFlights, 5000);
</script>

</body>
</html>
