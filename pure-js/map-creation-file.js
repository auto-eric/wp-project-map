

var map = L.map('map-file', { center: [52.5051, 13.4334], zoom: 13 });

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


fetch('../data/projects.json')
    .then(response => response.json())
    .then(jsonObj => {
        console.log("data: " + jsonObj.data)
        jsonObj.data.forEach( project => {
            const geoJson = JSON.parse(project.geojson);
            console.log("geoJson: " + geoJson);
            console.log("type", geoJson.type)
            var polygon = L.geoJSON(geoJson).addTo(map);
            polygon.bindPopup("<h1>"+project.title+"</h1><p>" + project.Hintergrund + "</p>");
        });
    })
