<?php

class Doppler_Locations_Activator {
	public static function activate() {
        // Initialize variables
        global $doppler_locations_plugin;
        $post_type_template = $doppler_locations_plugin->get_post_type_template(); // Get template post_type value
        $count = $doppler_locations_plugin->get_plugin_admin()->get_post_count($post_type_template);

        // Initialize settings
        if (get_option('doppler_location_slug') == false) add_option('doppler_location_slug', '');

        // Add default template if no template exists on activation
        if ($count <= 0) {
            $doppler_locations_plugin->get_plugin_admin()->add_post($post_type_template, false);
        }
    }
}