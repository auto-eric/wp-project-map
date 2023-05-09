# wp-project-map
The goal is to present projects on a map within Wordpress.

# Usage
* build plugin ZIP file ```zip -r projectmap.zip wp-plugin/```
* create projects ![create projects](/readme/projects.png)
* add shortcode to you page ![shortcode](/readme/shortcode.png)
  * `filter`: should a filter for the categories available (default: `true`)
  * `colors`: a key-value list to provide colors to the categories.
  * `center`: where the center of the map should get placed
  * `zoom`: initial zoom factor

## Development
### Requirements
* Docker to run Wordpress

### Local dev environment
![screenshot of the map](/readme/loaded-from-file.png)
* run docker containers ```docker-compose up```
* on the run you need to setup WP. 
  The docker container use the directories `db` and `wp` for their data. If the docker instances complain about missing directories. Create them manually.
* open in browser 
  * [the website](http://localhost:8880/)
  * [the admin panel](http://localhost:8880/wp-admin/)

### Generate input data
* 

## Todo
* CSS für popup
* kategorie system
* geo code editor
