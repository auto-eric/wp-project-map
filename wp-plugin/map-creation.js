
var projectTypes = new Set();

function handleClick(checkbox) {
    console.log("change " + checkbox.value + " -> value: " + checkbox.checked)
}

function handleProject(project) {
    if (project.meta.geojson !== null && project.meta.geojson !== '') {
        var col = categoryColors[project.meta.category];
        const geoJson = JSON.parse(project.meta.geojson);
        var polygon = L.geoJSON(geoJson, {
            style: {
                "color": col,
                "weight": "2",
                "opacity": 0.65
            }
        }).addTo(map);
        var popupHtml = "<h5>" + project.title.rendered + "</h5>"
            + "<p>" + project.meta.description + "</p>";
        if (typeof project.meta.link !== 'undefined' && project.meta.link !== '') {
            popupHtml += "<p><a href='" + project.meta.link + "'>Projektseite</a></p>"
        }
        polygon.bindPopup(popupHtml);
    } else {
        console.log("no GeoJSON for " + JSON.stringify(project));
    }
}

async function loadProjects() {
    try {
        const response = await fetch(wpApiSettings.root + wpApiSettings.versionString + 'projectmap?_fields=id,title,meta');
        const jsonObj = await response.json();
        localStorage.setItem('projects', JSON.stringify(jsonObj));
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
            checkboxHtml += "<input type=\"checkbox\" id=\"" + t + "\" value=\"" + t + "\" onclick=\"handleClick(this)\"> <label for=\"" + t + "\">" + t + "</label>"
        });
        checkboxHtml += "</form>";
        document.getElementById("filter").innerHTML = checkboxHtml;
    }

}
var db;
var request = window.indexedDB.open('projectmap', 2);

request.onerror = (event) => {
    console.log("Error loading database: " + JSON.stringify(event));
};

request.onsuccess = (event) => {
    console.log("connected to DB: " + JSON.stringify(event));
    db = request.result;
}

request.onupgradeneeded = (event) => {
    console.log("onupgradeneeded: " + JSON.stringify(event));
    const db = event.target.result;
    if (event.oldVersion < 2) {
        console.log("\told version: " + event.oldVersion);
        var projectStore = db.createObjectStrore("projects", { keypath: "id" });
        projectStore.createIndex("title", "title", { unique: false });
        projectStore.createIndex("description", "description", { unique: false });
        projectStore.createIndex("link", "link", { unique: false });
        projectStore.createIndex("geo_json", "geo_json", { unique: false });
        projectStore.createIndex("color", "color", { unique: false });

        var projectStore = db.createObjectStrore("categories");
        projectStore.createIndex("category", "category", { unique: false });
    }
}

// const transaction = db.transaction(["projects"], "readwrite");

// console.log("transaction: " + JSON.stringify(transaction));

// var projectStrore = db.transaction(['projects']).objectStore('projects');
// projectStrore.put({ id: 0, title: "test", description: "fdyfdsy" });
// try {
//     const response = fetch(wpApiSettings.root + wpApiSettings.versionString + 'projectmap?_fields=id,title,meta');
//     const jsonObj = response.json();
//     const category = jsonObj.map(project => {
//         handleProject(project);
//         return project.meta.category;
//     });
//     const categories = new Set(category);
//     console.log("types: " + JSON.stringify(categories));
//     return categories;
// } catch (error) {
//     console.log('could not read data', error);
// }


initialize();
