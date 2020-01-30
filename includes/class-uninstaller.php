<?php

class Doppler_Locations_Uninstaller {
	public static function uninstall() {
		// Declare variables
		global $doppler_locations_plugin;
		$post_type_location = $doppler_locations_plugin->get_post_type_location(); // Get template post_type value
		$post_type_template = $doppler_locations_plugin->get_post_type_template(); // Get template post_type value

		// Delete options
		delete_option('doppler_location_slug');

		// Delete all posts with post_type "location" or "template"
		$post_types = array($post_type_location, $post_type_template);
		foreach($post_types as $post_type) {
			$doppler_locations_plugin->get_plugin_admin()->delete_posts_by_type($post_type);
		}
	}
}