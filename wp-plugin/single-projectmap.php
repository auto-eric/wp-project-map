<link crossorigin="anonymous" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha384-o/2yZuJZWGJ4s/adjxVW71R+EO/LyCwdQfP5UWSgX/w87iiTXuvDZaejd3TsN7mf" rel="stylesheet">

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha384-okbbMvvx/qfQkmiQKfd5VifbKZ/W8p1qIsWvE1ROPUfHWsDcC8/BnHohF7vPg2T6"
    crossorigin="anonymous"></script>

<div id="content" role="main">

    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>
            <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                <h2><a href="<?php the_permalink() ?>" rel="bookmark"
                        title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <p>
                <h4>
                    <?php echo get_post_meta(get_the_ID(), 'projectmap-status', true) ?>
                </h4>
                <p>
                <p>
                    <?php echo get_post_meta(get_the_ID(), 'projectmap-description', true) ?>
                </p>
                <p><b>Kategorie:
                        <?php echo get_post_meta(get_the_ID(), 'projectmap-category', true) ?>
                    </b></p>

                <a href="<?php echo get_post_meta(get_the_ID(), 'projectmap-link', true) ?>"><?php echo get_post_meta(get_the_ID(), 'projectmap-link', true) ?></a>

                <h3>GeoJSON</h3>
                <p>
                    <?php echo get_post_meta(get_the_ID(), 'projectmap-geojson', true) ?>
                </p>

                <div id="projectmap" style="width: 802px; height: 400px;"></div>

                <script>
                    var map = L.map('projectmap', { center: [52.5051, 13.4334], zoom: 13 });

                    L.tileLayer(
                        'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                        {
                            maxZoom: 19,
                            attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
                        }).addTo(map);

                    const geoJson = JSON.parse('<?php echo get_post_meta(get_the_ID(), "projectmap-geojson", true) ?>');
                    var polygon = L.geoJSON(geoJson, {
                        style: {
                            "color": "#aa2222",
                            "weight": "2",
                            "opacity": 1
                        }
                    }).addTo(map);
                </script>

            </div>
        <?php endwhile; endif; ?>
</div>