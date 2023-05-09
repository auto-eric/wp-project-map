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
        wp_enqueue_style('projectmap', plugins_url('/style.css', __FILE__));
        error_log("shortcode attributes: " . print_r($attributes, true));

        $atts = shortcode_atts(
            [
                "filter" => "true",
                "colors" => "",
                "center" => "[52.5051, 13.4334]",
                "zoom" => "13"
            ],
            $attributes
        );

        error_log("filter: " . print_r($atts["filter"], true));
        error_log("colors: " . print_r($atts["colors"], true));


        $map_html = Shortcode::load_leaflet_scripts();
        $map_html .= Shortcode::parseColors($atts["colors"]);
        $map_html .= Shortcode::place_map_div($atts["filter"]);
        $map_html .= "<script>
            var map = L.map('projectmap', { center: [" . $atts['center'] . "], zoom: " . $atts['zoom'] . "  });
            
            L.tileLayer(
                'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    maxZoom: 19,
                    attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
                }).addTo(map);
                </script>";

        wp_enqueue_script(
            'projectmap-create',
            plugins_url('/map-creation.js', __FILE__),
            ['wp-api'],
            null,
            true
        );
        return $map_html;
    }

    public static function load_leaflet_scripts()
    {
        return '        <link crossorigin="anonymous"
        href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha384-o/2yZuJZWGJ4s/adjxVW71R+EO/LyCwdQfP5UWSgX/w87iiTXuvDZaejd3TsN7mf"
        rel="stylesheet">
          
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
                integrity="sha384-okbbMvvx/qfQkmiQKfd5VifbKZ/W8p1qIsWvE1ROPUfHWsDcC8/BnHohF7vPg2T6"
                crossorigin="anonymous"></script>
                ';
    }

    public static function parseColors($color_string)
    {
        $entries = explode(',', $color_string);
        $return_html = "<script>";
        $return_html .= "var categoryColors={";
        foreach ($entries as $c) {
            list($category, $color) = explode("=", $c);
            $return_html .= " $category: '$color',";
        }
        $return_html .= "};</script>";
        error_log("return_html: $return_html");
        return $return_html;
    }

    public static function place_map_div($set_filter)
    {
        $return_html = '
        <div class="parent">
            <div class="parent" style="width: 802px;    display: inline-block;">
                <div id="projectmap" class="child" style="width: 800px; height: 400px"></div>';
        error_log("set_filter: " . print_r($set_filter, true));
        if ($set_filter === 'true') {
            $return_html .= '
            <div id="filter" class="child" style="text-alignment: left">
                <form>
                    <input type="checkbox" id="bike" value="bike" onclick="handleClick(this)"> <label for="bike">Fahrrad</label>
                    <br/>
                    <input type="checkbox" id="pedestrian" value="pedestrian" onclick="handleClick(this)"> <label for="pedestrian">Fußgänger</label>
                </form>
            </div>';
        } else {
            error_log("set_filter = " . print_r($set_filter, true));
        }
        $return_html .= '
            </div>
        </div>';
        return $return_html;
    }
}

?>