const  access_TOKEN = 'pk.eyJ1IjoiYW50dW5lc21nOTMiLCJhIjoiY2p2ejg2NHg1MG53ZjQ4cGI5dXhyNTBwOSJ9.fgL-TH9_u7F5G7CTSF603g'

function startMap (id, center, zoom){
    var mymap = L.map(id).setView(center, zoom);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: access_TOKEN
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
function printMarker (map, marker) {
    var m = L.marker([marker[1], marker[2]], {icon: createIcon(marker[7])}).addTo(map);
    return m;
}