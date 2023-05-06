<?php
/*
 * Plugin Name: Project Map
 * Description: Brings custom type Project and can show these projects on a map.
 * Author: Eric Härtel
 * Author-URI: https://github.com/auto-eric/
 */

defined('ABSPATH') or die("No direct script access allowed.");

define('PLUGIN_NAME', 'projectmap');

include_once 'Shortcode.php';

function projectmap_setup_post_type()
{
    register_post_type(
        PLUGIN_NAME,
        [
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                'name' => __('Projekte', 'textdomain'),
                'singular_name' => __('Projekt', 'textdomain'),
            ),
            'supports' => ['title', 'revisions', 'custom_fields'],
        ]
    );
}
add_action('init', 'projectmap_setup_post_type');

function projectmap_add_post_metaboxes()
{
    add_meta_box(
        PLUGIN_NAME . '-category',
        'Kategorie',
        'projectmap_field_render_category',
        PLUGIN_NAME,
        'normal',
        'high'
    );

    add_meta_box(
        PLUGIN_NAME . '-link',
        'Link',
        'projectmap_field_render_link',
        PLUGIN_NAME,
        'normal',
        'high'
    );

    add_meta_box(
        PLUGIN_NAME . '-description',
        'Beschreibung',
        'projectmap_field_render_description',
        PLUGIN_NAME,
        'normal',
        'high'
    );

    add_meta_box(
        PLUGIN_NAME . '-geojson',
        'GeoJSON',
        'projectmap_field_render_geojson',
        PLUGIN_NAME,
        'normal',
        'high'
    );
}
;
add_action('add_meta_boxes', 'projectmap_add_post_metaboxes');

function register_meta_boxes()
{
    register_post_meta(
        PLUGIN_NAME, 
        PLUGIN_NAME . '-category',
        [
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ]
    );
}
add_action('init', 'register_meta_boxes');

function projectmap_field_render_category()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $category = $custom[PLUGIN_NAME . '-category'][0];
    echo '<input type="text" name="_category" value="' . $category . '" placeholder="Kategorie" />';
}

function projectmap_field_render_link()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $link = $custom[PLUGIN_NAME . '-link'][0];
    echo '<input type="url" name="_link" value="' . $link . '" placeholder="Projekt-Link" />';
}

function projectmap_field_render_description()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $description = $custom[PLUGIN_NAME . '-description'][0];
    echo '<textarea name="_description" placeholder="Projektbeschreibung" cols=100>' . $description . '</textarea>';
}

function projectmap_field_render_geojson()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $geojson = $custom[PLUGIN_NAME . '-geojson'][0];
    echo '<textarea name="_geojson" placeholder="GeoJSON" cols=100>' . $geojson . '</textarea>';
}

function projectmap_save_project()
{
    global $post;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    update_post_meta($post->ID, PLUGIN_NAME . '-category', sanitize_text_field($_POST['_category']));
    update_post_meta($post->ID, PLUGIN_NAME . '-link', sanitize_text_field($_POST['_link']));
    update_post_meta($post->ID, PLUGIN_NAME . '-description', sanitize_text_field($_POST['_description']));
    update_post_meta($post->ID, PLUGIN_NAME . '-geojson', sanitize_text_field($_POST['_geojson']));
}
add_action('save_post', 'projectmap_save_project');

function projectmap_activate()
{
    projectmap_setup_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'projectmap_activate');

/**
 * Deactivation hook.
 */
function projectmap_deactivate()
{
    unregister_post_type(PLUGIN_NAME);
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'projectmap_deactivate');

Shortcode::register();

function projectmap_resolve_template($template)
{
    global $post;
    if (PLUGIN_NAME === $post->post_type && locate_template('single-projectmap.php') !== $template) {
        return plugin_dir_path(__FILE__) . 'single-projectmap.php';
    }
    return $template;
}
add_filter('single_template', 'projectmap_resolve_template');
?>