# wp-project-map
The goal is to present projects on a map within Wordpress.

## Development
### Requirements
* Docker to run Wordpress

### Steps for Wordpress
![screenshot of the map](/readme/loaded-from-file.png)
* run docker containers ```docker-compose up```
* on the run you need to setup WP. 
  The docker container use the directories `db` and `wp` for their data. If the docker instances complain about missing directories. Create them manually.
* open in browser 
  * [the website](http://localhost:8880/)
  * [the admin panel](http://localhost:8880/wp-admin/)
* To upload not standard media additional permission is needed.
  *  [instructions](https://www.hostinger.com/tutorials/upload-svg-to-wordpress#Manually_Add_WordPress_SVG_Support)
* Include the script in a Wordpress page.
  * Upload the file `projects.json` to media section.
  * Insert an _individuel HTML_ element into the page and paste the content of [wordpress-integration/html-load-json.html](wordpress-integration/html-load-json.html)
  * Check the path to the project file in the script code.

### Steps for pure-js
The code in the `pure-js` directory is independent of Wordpress. 
A convenient way is to use Idea. When use `open in` &rarr; `browser` Idea starts a webserver to deliver the page to the browser.

### Generate input data
* You can generate GeoJSON on http://geojson.io
* OpenOffice Calc to JSON https://products.aspose.app/cells/conversion/ods-to-json

## Todo
* Define visual appearance
  * fill color
  * border: with and color
* 