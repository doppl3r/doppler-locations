<?php

class Doppler_Locations_Uninstaller {
	public static function uninstall() {
		// Declare variables
		global $doppler_locations_plugin;
		$post_types = array('location', 'template');

		// Delete all posts with post_type "location" or "template"
		foreach($post_types as $post_type) {
			$doppler_locations_plugin->get_plugin_admin()->delete_posts_by_type($post_type);
		}
	}
}