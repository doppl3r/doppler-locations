<?php

class Doppler_Locator_Activator {
	public static function activate() {
		global $wpdb, $doppler_locator_table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $doppler_locator_table_name;

        // Check to see if the table exists already, if not, then create it
        if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") != $table_name) 
        {
            // Create name and types columns for the first time
			$sql = "CREATE TABLE " . $table_name . " 
			( 
                id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                name VARCHAR(50) NOT NULL,
                points INT(6) NOT NULL,
                PRIMARY KEY (id)
			) " . $charset_collate . ";";
			
			//echo ($sql); die;

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
		}
	}
}