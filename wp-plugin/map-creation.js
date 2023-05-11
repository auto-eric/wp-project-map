
let projectTypes = new Set();
var typeProjectMap = {};

function handleProject(project) {
    if (project.meta.geojson !== null && project.meta.geojson !== '') {
        let col = categoryColors[project.meta.category];

        const geoJson = JSON.parse(project.meta.geojson);
        let polygon = L.geoJSON(geoJson, {
            style: {
                "color": col,
                "weight": "2",
                "opacity": 0.65
            }
        }).addTo(map);
        polygon.bindPopup(generatePopupHtml(project))
        putGeoJsonIntoMap(polygon, project.meta.category);
    } else {
        console.log("no GeoJSON for " + JSON.stringify(project));
    }
}

function putGeoJsonIntoMap(geoJson, category) {
    if (typeof typeProjectMap[category] === 'undefined') {
        typeProjectMap[category] = new Set();
    }
    typeProjectMap[category].add(geoJson);
}

function generatePopupHtml(project) {
    let popupHtml = "<h5>" + project.title.rendered + "</h5>"
    if (typeof project.meta.status !== 'undefined' && project.meta.status !== '') {
        popupHtml += "<p>Status: " + project.meta.status + "</p>";
    }
    popupHtml += "<p>" + project.meta.description + "</p>";
    if (typeof project.meta.link !== 'undefined' && project.meta.link !== '') {
        popupHtml += "<p><a href='" + project.meta.link + "'>Projektseite</a></p>"
    }
    return popupHtml;
}

async function loadProjects() {
    try {
        const response = await fetch(wpApiSettings.root + wpApiSettings.versionString + 'projectmap?_fields=id,title,meta');
        const jsonObj = await response.json();
        const category = jsonObj.map(project => {
            handleProject(project);
            return project.meta.category;
        });
        const categories = new Set(category);
        console.log("types: " + JSON.stringify(categories));
        return categories;
    } catch (error) {
        console.log('could not read data', error);
    }
}

async function initialize() {

    projectTypes = await loadProjects();

    if (document.getElementById("filter")) {
        var checkboxHtml = "<form>";
        projectTypes.forEach(t => {
            checkboxHtml += "<input type=\"checkbox\" id=\"" + t + "\" value=\"" + t + "\" checked onclick=\"handleClick(this)\"> <label for=\"" + t + "\">" + t + "</label>"
        });
        checkboxHtml += "</form>";
        document.getElementById("filter").innerHTML = checkboxHtml;
    }

}

function handleClick(checkbox) {
    let category = checkbox.value;
    let visible = checkbox.checked;
    typeProjectMap[category].forEach(o => {
        if (visible) {
            o.addTo(map);
        } else {
            o.remove();
        }
        console.log(o);
    });
}

initialize();
