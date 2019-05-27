const  ACCESS_TOKEN = 'pk.eyJ1IjoiYW50dW5lc21nOTMiLCJhIjoiY2p2ejg2NHg1MG53ZjQ4cGI5dXhyNTBwOSJ9.fgL-TH9_u7F5G7CTSF603g'

function startMap (id, center, zoom){
    var mymap = L.map(id, {editable: true}).setView(center, zoom);
    
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: ACCESS_TOKEN
    }).addTo(mymap);


    return mymap;
}

function createIcon (url) {
    var icon = L.icon({
        iconUrl: 'http://maps.google.com/mapfiles/ms/icons/' + url,
        iconSize: [24,30],
        iconAnchor: [12,36]
    });
    return icon;
}

function printMarker (map, coords, url, isDraggable = false) {
    var m = L.marker(coords, {icon: createIcon(url), draggable: isDraggable}).addTo(map);
    return m;
}

function eraseMarkers (map) {
    map.eachLayer(function (layer) { 
        if(layer instanceof L.Marker) map.removeLayer(layer);
    });
}

function getLat (marker) {
    return marker._latlng.lat;
}

function getLng (marker) {
    return marker._latlng.lng;
}

function buildRectangle (map, lower, upper) {
    var bounds = [lower, upper];
    // create an orange rectangle
    var rectangle = L.rectangle(bounds, {color: "#ff7800", weight: 1}).addTo(map);
    rectangle.enableEdit();

    // zoom the map to the rectangle bounds
    map.fitBounds(bounds);
}

function fitToBounds (map, bounds) {
    map.fitBounds(bounds);
}