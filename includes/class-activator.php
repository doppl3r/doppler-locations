<?php

class Doppler_Locator_Activator {
	public static function activate() {
        // TODO: Check to see if any posts with post_type = "template" and generate defaults posts if it does not exist


        /*
        global $wpdb, $doppler_locator_table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $doppler_locator_table_name;

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") != $table_name) 
        {
			$sql = "CREATE TABLE " . $table_name . " 
			( 
                id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                name VARCHAR(50) NOT NULL,
                points INT(6) NOT NULL,
                PRIMARY KEY (id)
			) " . $charset_collate . ";";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
        */
	}
}