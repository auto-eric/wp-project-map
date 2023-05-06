<?php

defined('ABSPATH') or die("No direct script access allowed.");

class Shortcode
{
    public static function register()
    {
        // Register the new shortcode for embeds.
        add_shortcode(PLUGIN_NAME, 'Shortcode::do_shortcode');
    }

    public static function do_shortcode($attributes = [], $content = null, $shortcode_tag)
    {
        $map_html = '
        <link crossorigin="anonymous"
        href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha384-o/2yZuJZWGJ4s/adjxVW71R+EO/LyCwdQfP5UWSgX/w87iiTXuvDZaejd3TsN7mf"
        rel="stylesheet">
  
        <link href="style.css" rel="stylesheet">
        
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
                integrity="sha384-okbbMvvx/qfQkmiQKfd5VifbKZ/W8p1qIsWvE1ROPUfHWsDcC8/BnHohF7vPg2T6"
                crossorigin="anonymous"></script>
        
        <div class="parent">
            <div class="parent" style="width: 802px;    display: inline-block;">
                <div id="map-file" class="child" style="width: 800px; height: 400px"></div>
                <div id="filter" class="child" style="text-alignment: left">
                    <form>
                        <input type="checkbox" id="bike" value="bike" onclick="handleClick(this)"> <label for="bike">Fahrrad</label>
                        <br/>
                        <input type="checkbox" id="pedestrian" value="pedestrian" onclick="handleClick(this)"> <label for="pedestrian">Fußgänger</label>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
        var map = L.map(\'map-file\', { center: [52.5051, 13.4334], zoom: 13 });

        L.tileLayer(\'https://tile.openstreetmap.org/{z}/{x}/{y}.png\',
            {
                maxZoom: 19,
                attribution: \'&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>\'
            }).addTo(map);

        </script>';
        return $map_html;
    }
}

?>