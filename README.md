# wp-project-map
The goal is to present projects on a map within Wordpress.

## Development
### Requirements
* Docker to run Wordpress

### Steps for Wordpress
* run docker containers ```docker-compose up```
* on the run you need to setup WP. 
  The docker container use the directories `db` and `wp` for their data. If the docker instances complain about missing directories. Create them manually.
* open in browser 
  * [the website](http://localhost:8880/)
  * [the admin panel](http://localhost:8880/wp-admin/)
* To upload not standard media additional permission is needed.
  *  [instructions](https://www.hostinger.com/tutorials/upload-svg-to-wordpress#Manually_Add_WordPress_SVG_Support)

### Steps for pure-js
The code in the `pure-js` directory is independent of Wordpress. 
A convenient way is to use Idea. When use `open in` &rarr; `browser` it leads the browser to a server

### Generate input data
* You can generate GeoJSON on http://geojson.io
* OpenOffice Calc to JSON https://products.aspose.app/cells/conversion/ods-to-json