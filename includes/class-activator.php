<?php

class Doppler_Locations_Activator {
	public static function activate() {
        // Initialize variables
        global $doppler_locations_plugin;
        $post_type = "template";
        $count = $doppler_locations_plugin->get_plugin_admin()->get_post_count($post_type);

        // Add default template if no template exists on activation
        if ($count <= 0) {
            $doppler_locations_plugin->get_plugin_admin()->add_post($post_type, false);
        }
    }
}