function createIcon(file) {
    return L.icon({
        iconUrl: file,
        iconSize: [40, 40],
    });
}

var openStatusIcon = createIcon('pin-open.svg');
var doneStatusIcon = createIcon('pin-done.svg');
var unknownStatusIcon = createIcon('pin-unknown.svg');

function createMarker(map, latLng, title, status, description, link) {
    var icon = createIcon('pin-'+status+'.svg');
    var marker = L.marker(latLng, {icon: openStatusIcon}).addTo(map);
    var content = '<h3>' + title + '</h3> <p>' + description+ '<br /><a href="' + link + '">Projektseite</a></p>';
    marker.bindPopup(content);
}

var map = L.map('map-basic', { center: [52.5051, 13.4334], zoom: 13 });
L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

createMarker(map, [52.5051, 13.4334], 'Thema A', 'open' ,'kurze Beschreibung', 'https://leafletjs.com/reference.html#popup')
createMarker(map, [52.5151, 13.4334], 'Thema B', 'done' ,'hier steht auch irgendwas', 'https://leafletjs.com/reference.html#popup')
createMarker(map, [52.5251, 13.4334], 'Thema C', 'unknown' ,'und noch mehr Beschreibung mit viel BlahBlah und so weiter und so fort', 'https://leafletjs.com/reference.html#popup')

fetch('geo.json')
  .then(response => response.json())
  .then(jsonObj => {
    var polygon = L.geoJSON(jsonObj).addTo(map);
    polygon.bindPopup("test");
  })
  .catch(error => console.error(error));

