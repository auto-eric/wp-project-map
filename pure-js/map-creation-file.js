

var map = L.map('map-file', { center: [52.5051, 13.4334], zoom: 13 });


fetch('../data/projects.json')
    .then(response => response.json())
    .then(jsonObj => {
        console.log("data: " + jsonObj.data)
        jsonObj.data.forEach( project => {
            const geoJson = project.geojson;
            console.log("geoJson: " + geoJson);
            var polygon = L.geoJSON(geoJson).addTo(map);
            polygon.bindPopup("<h1>"+project.title+"</h1><p>" + project.Hintergrund + "</p>");
        });
    })
