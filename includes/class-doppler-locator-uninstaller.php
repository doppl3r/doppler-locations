<?php

class Doppler_Locator_Uninstaller {
	public static function uninstall() {
		// drop a custom database table
		global $wpdb, $doppler_locator_table_name;
		$table_name = $doppler_locator_table_name;
		$wpdb->query("DROP TABLE IF EXISTS " . $table_name);
	}
}