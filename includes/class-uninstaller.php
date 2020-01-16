<?php

class Doppler_Locator_Uninstaller {
	public static function uninstall() {
		// TODO: Delete all posts with post_type = "location" and "template"
		// TODO: unregister post_type "location" and "template
		// TODO: Delete all post media with "doppler-locator" in description


		// drop a custom database table
		/*
		global $wpdb, $doppler_locator_table_name;
		$table_name = $doppler_locator_table_name;
		$wpdb->query("DROP TABLE IF EXISTS " . $table_name);
		*/
	}
}