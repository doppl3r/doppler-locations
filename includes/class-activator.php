<?php

class Doppler_Locator_Activator {
	public static function activate() {
        // Initialize variables
        global $doppler_locator_plugin;
        $post_type = "template";
        $count = $doppler_locator_plugin->get_plugin_admin()->get_post_count($post_type);

        // Add default template if no template exists on activation
        if ($count <= 0) {
            $doppler_locator_plugin->get_plugin_admin()->add_post($post_type);
        }
    }
}