<?php

class Doppler_Locator_Activator {
	public static function activate() {
        // Initialize variables
        global $doppler_locator_plugin;
        $count = $doppler_locator_plugin->get_plugin_admin()->get_template_count();

        // Add default template if no template exists on activation
        if ($count <= 0) {
            $doppler_locator_plugin->get_plugin_admin()->add_template();
        }
    }
}