const defaultStyle= {
    "color": "#333333",
    "weight": "2",
    "opacity": 0.65
};
const bikeStyle= {
    "color": "#3300bb",
    "weight": "2",
    "opacity": 0.65
};
const pedestrianStyle= {
    "color": "#bb00bb",
    "weight": "2",
    "opacity": 0.65
};

var projectTypes = new Set();

function handleClick(checkbox) {
    console.log("change " + checkbox.value + " -> value: " + checkbox.checked)

    
}

function handleProject(project) {
    const geoJson = JSON.parse(project.geojson);
    switch (project.type) {
        case "bike":
            var theStyle = bikeStyle;
            break;
        case "pedestrian":
            var theStyle = pedestrianStyle;
            break;
        default:
            var theStyle = defaultStyle;
    }
    var polygon = L.geoJSON(geoJson, {style: theStyle}).addTo(map);
    polygon.bindPopup("<h3>"+project.title+"</h3><p>" + project.Hintergrund + "</p>");
}

async function loadProjects() {
    try {
        const response = await fetch('../data/projects.json');
        const jsonObj = await response.json();
        const types = jsonObj.data.map(project => {
            handleProject(project);
            return project.type;
        });
        const projectTypes = new Set(types);
        console.log("types: " + projectTypes);
        return projectTypes;
    } catch (error) {
        console.log('could not read data', error);
    }
}

async function initialize() {
    projectTypes = await loadProjects();

    var checkboxHtml = "<form>";
    projectTypes.forEach(t => {
        checkboxHtml += "<input type=\"checkbox\" id=\"" + t + "\" value=\"" + t +"\" onclick=\"handleClick(this)\"> <label for=\"" + t + "\">" + t + "</label>"
    });
    checkboxHtml += "</form>";
    console.log(checkboxHtml);

    document.getElementById("filter").innerHTML = checkboxHtml;
}

var map = L.map('map-file', { center: [52.5051, 13.4334], zoom: 13 });

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


initialize();
